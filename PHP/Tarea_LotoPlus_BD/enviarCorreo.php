<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$titulo = "Enviar correo validación | LotoPlus";
require("includes/cabecera.php");

if(isset($_SESSION["usuarioValidado"]) || isset($_SESSION["usuarioAdmin"]) ){

require("vendor/autoload.php");

if(isset($_SESSION["usuarioValidado"])){
    $nombreUsuario = $_SESSION["usuarioValidado"];
}else{
    $nombreUsuario = $_SESSION["usuarioAdmin"];
}

$con = conectar();
$sql = "SELECT * from usuarios where nomusu = '$nombreUsuario';";
$res = mysqli_query($con, $sql) or die(mysqli_error($con));
$resultado = mysqli_fetch_array($res);
$email = $resultado["email"];

//En caso de que al enviar correo se de un error desconocido se recomienda comentar el código desde esta línea hasta el final de catch
$mail = new PHPMailer(true);
try {
    $mail->isSMTP();
    $mail->SMTPOptions = [
        'ssl' => [
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true,
        ],
    ];
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = "adlotoplus@gmail.com";
    $mail->Password = "adfv asoc hots pqpi";
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    $mail->setFrom("adlotoplus@gmail.com", "Administración LotoPlus");
    $mail->addAddress($email);

    $mail->isHTML(true);
    $directorioAbsoluto = dirname(__FILE__); // Por ejemplo: C:\xampp\htdocs\proyecto\subcarpeta
    $raizProyecto = rtrim($_SERVER['DOCUMENT_ROOT'], DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR; // Por ejemplo: C:\xampp\htdocs
    $rutaRelativa = str_replace($raizProyecto, '', $directorioAbsoluto); // /proyecto/subcarpeta

    // Asegúrate de que la ruta tenga formato correcto para URLs
    $rutaRelativa = str_replace('\\', '/', $rutaRelativa);
    $partesRuta = explode('/', $rutaRelativa);
    // Obtener las carpetas desde el índice 3 hasta el final
    $carpetasImportantes = implode('/', array_slice($partesRuta, 3));
    $url = "http://localhost/$carpetasImportantes/validarUsuario.php";
    $mail->Subject = "Valida tu cuenta";
    $mail->Body = "Hola, por favor valida tu cuenta haciendo clic en el siguiente enlace:<br>
                    <a href='$url'>Validar cuenta</a>";

    $mail->send();
    header("Location: index.php?titulo=Éxito&mensaje=Se ha enviado un correo al email indicado para validar su cuenta&tipoMensaje=success&colorIcono=ForestGreen");
} catch (Exception $e) {
    echo "Error al enviar el correo: {$mail->ErrorInfo}";
}

} else{
?>
    <div class="container-principal">       
        <div class="container-aviso">
            <h1>Debes iniciar sesión como administrador para acceder a esta sección</h1>
            <p>Para ver tu información <a href="formularioIniciarSesion.php">inicia sesión</a></p>
            <p>Si no dispones de una cuenta de administrador <a href="index.php">vuelve al inicio</a></p>
        </div>
    </div>
<?php
}

require("includes/pie.php");
?>