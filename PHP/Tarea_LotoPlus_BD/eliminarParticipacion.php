<?php
$titulo = "Eliminar Participación | LotoPlus";
require("includes/cabecera.php");

if(isset($_SESSION["usuarioValidado"]) || isset($_SESSION["usuarioAdmin"])){
    if (isset($_POST["eliminar"])) {
        $idpart = $_POST["eliminar"];
        $con = conectar();
        mysqli_report(MYSQLI_REPORT_OFF);
    
        $sql = "DELETE FROM participaciones WHERE idpart = $idpart";
        $resultado = mysqli_query($con, $sql);
        mysqli_close($con);
        
        if ($resultado) {
            // Redirige con un mensaje de éxito
            header("Location: participaciones.php?mensaje=Participación eliminada&tipoMensaje=success");
            exit;
        } else {
            // Redirige con un mensaje de error
            header("Location: participaciones.php?mensaje=Error al eliminar participación&tipoMensaje=error");
            exit;
        }
        
    } else {
        echo "<p>No se recibió ninguna participación para eliminar.</p>";
    }
}else {
    ?>
        <div class="container-principal">       
            <div class="container-aviso">
                <h1>Debes iniciar sesión para acceder a esta sección</h1>
                <p>Para acceder <a href="formularioIniciarSesion.php">inicia sesión</a></p>
                <p>Si no dispones de una cuenta de usuario<a href="formularioCrearUsuario.php"> puedes crearla</a></p>
            </div>
        </div>
    <?php
}
require('includes/pie.php');
?>