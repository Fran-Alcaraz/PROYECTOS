<?php
$titulo = "Eliminar Sorteo | LotoPlus";
require("includes/cabecera.php");

if(isset($_SESSION["usuarioAdmin"])){
    if (isset($_POST["eliminar"])) {
        $con = conectar();
        $idsorteo = intval($_POST["eliminar"]); // Sanitiza el valor
        $sql = "DELETE FROM sorteos WHERE idsorteo = $idsorteo";
        $resultado = mysqli_query($con, $sql);

        if ($resultado) {
            // Redirige con un mensaje de éxito
            header("Location: sorteos.php?mensaje=Sorteo eliminado&tipoMensaje=success");
            exit;
        } else {
            // Redirige con un mensaje de error
            header("Location: sorteos.php?mensaje=Error al eliminar el sorteo&tipoMensaje=error");
            exit;
        }
        mysqli_close($con);
    } else {
        echo "<p>No se recibió ningún sorteo para eliminar.</p>";
    }
}else {
    ?>
        <div class="container-principal">       
            <div class="container-aviso">
                <h1>Debes iniciar sesión como administrador para acceder a esta sección</h1>
                <p>Para acceder <a href="formularioIniciarSesion.php">inicia sesión</a></p>
                <p>Si no dispones de una cuenta de administrador<a href="index.php"> vuelve al inicio</a></p>
            </div>
        </div>
    <?php
}
require('includes/pie.php');
?>
