<?php
$titulo = "Crear Premio | LotoPlus";
require("includes/cabecera.php");

if(isset($_POST["enviar"])){
    $idsorteo = $_POST["idsorteo"];
    $numPremiado = $_POST["numPremiado"];
    $premio = $_POST["premio"];

    $con = conectar();
    
    $sql = "SELECT * from premios where idsorteo = $idsorteo and numero = $numPremiado;";
    $res = mysqli_query($con, $sql) or die(mysqli_error($con));

    if(mysqli_num_rows($res) > 0){
            echo "<script>
                Swal.fire({
                    title: 'Error',
                    text: 'Ese número ya tiene premio en ese sorteo',
                    confirmButtonText: 'Aceptar',
                    confirmButtonColor: '#19778a',
                    icon: 'error',
                    iconColor: 'red'
                });
            </script>";
        }else{
            $sentencia = mysqli_stmt_init($con);
            $sql = "INSERT into premios(idsorteo, numero, premio) values (?, ?, ?);";
            mysqli_stmt_prepare($sentencia, $sql);
            mysqli_stmt_bind_param($sentencia, 'iid', $idsorteo, $numPremiado, $premio); 
            $res = mysqli_stmt_execute($sentencia) or die(mysqli_error($con));
            mysqli_close($con);
            header("Location: premios.php?mensaje=Premio creado correctamente&tipoMensaje=success");
            exit;
        }
}

// Cargar sorteos y participaciones
$con = conectar();
$sql = "SELECT * FROM sorteos;";
$sorteos = mysqli_query($con, $sql) or die(mysqli_error($con));

$participaciones = [];
$sql = "SELECT idsorteo, numero FROM participaciones;";
$res = mysqli_query($con, $sql) or die(mysqli_error($con));
while ($fila = mysqli_fetch_array($res)) {
    $participaciones[$fila['idsorteo']][] = $fila['numero'];
}

if(isset($_SESSION["usuarioAdmin"])){
?>
<div class="form-container">
    <fieldset class="form-premio" style="height: 190px;">
        <legend><span class="titulo">LotoPlus</span><img src="images/lotoplus.png" width="30px"><span class="titulo">CREAR PREMIO</span></legend>
        <form action="<?= $_SERVER["PHP_SELF"] ?>" method="post">
            <table>
                <tr>
                    <td><select name="idsorteo" id="idsorteo" required>
                        <option value="" disabled selected>Elige un sorteo</option>
                        <?php
                            $con = conectar();
                            $sql = "SELECT * from sorteos;";
                            $res = mysqli_query($con, $sql) or die(mysqli_error($con));
                            $primero = true;

                            while($fila = mysqli_fetch_row($res)){
                                if($primero){
                                    echo "<option value='".$fila[0]."'>".$fila[1]."</option>";
                                    $primero = false;
                                }else {
                                    echo "<option value='".$fila[0]."'>".$fila[1]."</option>";
                                }
                            }
                        ?>
                    </select></td>
                    <td colspan="2">
                        <select name="numPremiado" id="numPremiado" required>
                            <option value="" disabled>Seleccione un número</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td colspan="2"><input type="number" name="premio" id="premio" placeholder="Premio" style="margin-bottom: 10px;" required></td>
                </tr>
                <tr>
                    <td><input type="submit" name="enviar" value="CREAR PREMIO"></td>   
                    <td colspan="4"><input type="reset" value="CANCELAR"></td>
                </tr>
            </table><br>
        </form>
    </fieldset>
</div>
<script>
    // Cargar datos de participaciones desde PHP
    const participacionesPorSorteo = <?= json_encode($participaciones) ?>;

    // Elementos del formulario
    const sorteoSelect = document.getElementById("idsorteo");
    const numeroSelect = document.getElementById("numPremiado");

    // Escuchar cambios en el sorteo seleccionado
    sorteoSelect.addEventListener("change", function () {
        const idSorteo = this.value;

        // Limpiar las opciones previas del select de números
        numeroSelect.innerHTML = "<optgroup value='' label='Números del sorteo con ID " + idSorteo +"'></optgroup>";

        // Si hay participaciones para el sorteo seleccionado, añadirlas al select
        if (participacionesPorSorteo[idSorteo]) {
            participacionesPorSorteo[idSorteo].forEach(numero => {
                const option = document.createElement("option");
                option.value = numero;
                option.textContent = numero;
                numeroSelect.appendChild(option);
            });
        }
    });
</script>
<?php
}else {?>
    <div class="container-principal">       
        <div class="container-aviso">
            <h1>Debes iniciar sesión como administrador para acceder a esta sección</h1>
            <p>Para ver tu información <a href="formularioIniciarSesion.php">inicia sesión</a></p>
            <p>Si no dispones de una cuenta de administrador <a href="index.php">vuelve al inicio</a></p>
        </div>
    </div>
<?php
}
require('includes/pie.php');
?>