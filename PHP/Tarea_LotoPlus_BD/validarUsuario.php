<?php
$titulo = "Validar cuenta | LotoPlus";
require("includes/cabecera.php");
    $con = conectar();
    $nombreUsuario = $_SESSION["usuarioValidado"];
    $sql = "UPDATE usuarios set validada = 'S' where nomusu = '$nombreUsuario';";
    $res = mysqli_query($con, $sql) or die(mysqli_error($con));
?>
<section class="container-principal">
    <div class="container-aviso">
        <h1>Cuenta validada con éxito</h1>
        <p>Ha validado su usuario <b><?php echo $nombreUsuario?></b> correctamente, puede cerrar esta ventana</p>
    </div>
</section>
<?php
require("includes/pie.php");
?>