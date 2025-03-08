<?php
$titulo = "Eliminar Usuario | LotoPlus";
require("includes/cabecera.php");

if(isset($_SESSION["usuarioAdmin"])){
    if (isset($_POST["eliminar"])) {
        $idusuario = $_POST["eliminar"];
        $con = conectar();
        mysqli_report(MYSQLI_REPORT_OFF);

        $sql = "DELETE FROM usuarios WHERE idusuario = $idusuario";
        $resultado = mysqli_query($con, $sql);
        mysqli_close($con);

        if ($resultado) {
            // Redirige con un mensaje de éxito
            header("Location: usuarios.php?titulo=Éxito&mensaje=Usuario eliminado&tipoMensaje=success&colorIcono=ForestGreen");
            exit;
        } else {
            // Redirige con un mensaje de error
            header("Location: usuarios.php?titulo=Error&mensaje=El usuario tiene participaciones asociadas&tipoMensaje=error&colorIcono=red");
            exit;
        }
        
    } else {
        echo "<p>No se recibió ningún usuario para eliminar.</p>";
    }
}else{
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