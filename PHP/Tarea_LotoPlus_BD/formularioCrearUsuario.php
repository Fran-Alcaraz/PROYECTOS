<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$titulo = "Crear Usuario | LotoPlus";
require("includes/cabecera.php");
require("vendor/autoload.php");
/*Si se ha pulsado el botón submit guardo toda la información en variables para facilitar su acceso y, en caso contrario, muestro
        el formulario*/
if (isset($_POST['enviar'])) {
    $nombre = $_POST["nombre"];
    $apellidos = $_POST["apellidos"];
    $nombreUsuario = $_POST["nombreUsuario"];
    $passwd = $_POST["passwd"];
    $nivelFortaleza = 0;
    $email = $_POST["email"];
    $fechaNac = new DateTime($_POST["fechaNac"]);
    $tipoCuenta = $_POST["tipoCuenta"];
    $gananciasIniciales = $_POST["gananciasIniciales"];
    $telefono = $_POST["telefono"];
    $aceptaCondiciones = $_POST["aceptaCondiciones"] ? $_POST["aceptaCondiciones"] : "N";
    $marketing = isset($_POST["marketing"]) ? "S" : "N";
    $rutaFichero = "";
    $tipoUsuario = isset($_SESSION["usuarioAdmin"]) ? $_POST["tipousu"] : "n";
    $fechaNacFinal = $fechaNac->format("Y-m-d");
    $claveCifrada = password_hash($passwd, PASSWORD_DEFAULT);

    //Creo una variable para comprobar si ha habido algún error en el formulario
    $error = false;

    $con = conectar();
    $sqlNombre = "select idusuario from usuarios where nomusu = '" . $nombreUsuario . "';";
    $res = mysqli_query($con, $sqlNombre) or die(mysqli_error($con));

    if (mysqli_num_rows($res) > 0) {
        $errores["nombreUsuarioRepetido"] = "Ese nombre de usuario se encuentra en uso.";
        $error = true;
    } else {
        $errores["nombreUsuarioRepetido"] = "";
    }

    mysqli_free_result($res);
    mysqli_close($con);

    /*Compruebo la longitud del nombre de usuario que esté en el rango de caracteres indicados y que solo tenga letras y números 
            usando la función preg_match con el patrón ahí indicado. Es necesario poner la exclamación delante ya que así indicamos
            que queremos que se cumpla si no coincide con el patrón, es decir, si tiene caracteres que no sean letras o dígitos.

            Si se cumple la condición se guarda un mensaje con el error en un array asociativo y se guarda true en la variable de error 
            y, si no se cumple, guarda una cadena vacía*/
    $longitudNombreUsuario = strlen($nombreUsuario);
    if (($longitudNombreUsuario < 3) || ($longitudNombreUsuario > 30) || (!preg_match("/^[a-zA-Z0-9]+$/", $nombreUsuario))) {
        $errores["nombreUsuario"] = "La longitud debe ser mayor o igual que 3 y menor o\nigual que 30 y solo puede contener letras y dígitos";
        $error = true;
    } else {
        $errores["nombreUsuario"] = "";
    }

    /*Compruebo que la longitud de la contraseña esté en el rango indicado. Si no se cumple guarda un mensaje de error y guarda
            true en la variable de error y, si se cumple, comprueba el nivel de fortaleza de esta*/
    $longitudContrasenya = strlen($passwd);
    if (($longitudContrasenya < 4) || ($longitudContrasenya > 20)) {
        $errores["contrasenya"] = "La longitud debe ser mayor o igual que 4 y menor o igual que 20";
        $error = true;
    } else {
        $errores["contrasenya"] = "";
        /*Sumamos niveles de fortaleza a la contraseña si cumple con la longitud indicada y, usando preg_match(), si coincide con 
                los patrones para comprobar que tiene letras mayúsculas, minúsculas, números y caracteres especiales. Cuantas más
                condiciones cumpla más fuerte será*/
        $nivelFortaleza = (strlen($passwd) >= 4 && strlen($passwd) <= 20) + preg_match('/[A-Z]/', $passwd) +
            preg_match('/[a-z]/', $passwd) + preg_match('/[0-9]/', $passwd) + preg_match('/[\W_]/', $passwd);

        //Asociamos cada nivel de fortaleza a un color siendo rojo el más débil y verde oscuro el más fuerte
        $coloresFortaleza = [1 => "bg-rojo", 2 => "bg-naranja", 3 => "bg-amarillo", 4 => "bg-verde", 5 => "bg-verde-oscuro"];

        /*Al ser 5 niveles multiplicamos el nivel de fortaleza por 20 para tener un porcentaje para el ancho de la barra de 
                fortaleza*/
        $porcentajeFortaleza = $nivelFortaleza * 20;

        /*Guardamos el color en una variable para pasarla como clase a la barra y que coja el color de la clase y, si no recibe
                ninguna, se pasa el gris por defecto*/
        $color = $coloresFortaleza[$nivelFortaleza] ?? "bg-gris";
    }

    /*Comprobamos que el email tenga un formato válido y, si no lo tiene, guarda un mensaje de error en el array e indica true en 
            la variable error*/
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errores["email"] = "<br>El email debe contener @ y tener un formato correcto";
        $error = true;
    } else {
        $errores["email"] = "";
    }

    /*Comprobamos que el nº de teléfono es español usando !preg_match con el patrón indicado para comprobar que el teléfono empieza
            por 6 o 7 y, aparte de este caracter, tenga 8 caracteres más delante. Si se cumple la condición y no coincide con el patrón
            se guarda un mensaje de error en el array y se indica true en la variable error*/
    if (!preg_match("/^[679]\d{8}$/", $telefono)) {
        $errores["telefono"] = "El nº de teléfono debe ser de España";
        $error = true;
    } else {
        $errores["telefono"] = "";
    }

    //Calculamos la edad del usuario usando el método diff en la fecha que nos da y calculando la diferencia con la fecha actual
    $fechaActual = new DateTime();
    $edadUsuario = $fechaNac->diff($fechaActual)->y;

    //Si la edad del usuario es menor de 18 guardamos un mensaje de error en el array e indicamos true en la variable de error
    if ($edadUsuario < 18) {
        $errores["edad"] = "Debe ser mayor de 18 años";
        $error = true;
    } else {
        $errores["edad"] = "";
    }

    //Creo un array con las extensiones de archivo que se permiten subir
    $extensionesPermitidas = ["image/gif", "image/jpeg", "image/png"];

    /*Compruebo que el archivo se haya subido y que, si el tamaño es mayor de 4096KB o la extensión del archivo subido no está
            en el array creado anteriormente, se cumpla el if guardando un mensaje de error e indicando true en la variable error*/
    if (is_uploaded_file($_FILES['fotoPerfil']['tmp_name']) && (($_FILES['fotoPerfil']['size'] > 4194304) || (!in_array($_FILES['fotoPerfil']['type'], $extensionesPermitidas)))) {
        $errores["tamanyo"] = "<br>Solo se permiten JPG, PNG o GIF y el tamaño debe ser menor de 4096KB";
        $error = true;
    } else {
        $errores["tamanyo"] = "";
    }

    /*Si en ningún momento la variable de error ha cambiado a true, el formulario se procesa mostrando todos los datos 
            introducidos. En caso contrario, se vuelve a mostrar el formulario mostrando los mensajes de error que se hayan encontrado y
            mostrando el contenido de aquellos campos que no han tenido error*/
    if ($error == false) {
        //Compruebo que el archivo se haya subido correctamente
        if (!is_uploaded_file($_FILES['fotoPerfil']['tmp_name'])) {
            echo "";
        } else if (is_uploaded_file($_FILES['fotoPerfil']['tmp_name'])) {
            /*Si se ha subido correctamente guardamos un nuevo nombre de directorio y, si este no existe, se crea dando 
                    permisos a todos (0777)*/
            $nombreDirectorio = dirname(__FILE__) . '/uploads/';
            if (!is_dir($nombreDirectorio)) {
                mkdir($nombreDirectorio, 0777, true);
            }
            /*Guardo un nombre de fichero completo usando el de directorio que acabo de crear y el nombre real del archivo
                    subido*/
            $nombreFichero = $_FILES['fotoPerfil']['name'];
            $nombreCompletoFichero = $nombreDirectorio . $nombreFichero;

            /*Comprobamos que efectivamente el nombre completo es un fichero y, si lo es, creamos un id único para este y 
                    guardo como nuevo nombre de fichero este id con el nombre original del archivo y lo guardamos junto al
                    directorio como nuevo nombre completo*/
            if (is_file($nombreCompletoFichero)) {
                $idUnico = time();
                $nombreFichero = $idUnico . "-" . $nombreFichero;
                $nombreCompletoFichero = $nombreDirectorio . $nombreFichero;
            }

            //Muevo el archivo a la ruta que hemos indicado y muestro la imagen
            move_uploaded_file($_FILES['fotoPerfil']['tmp_name'], $nombreCompletoFichero);
            $rutaFichero = "uploads/" . $nombreFichero;
        } else {
            $rutaFichero = "No se ha subido ningún archivo";
        }

        $con = conectar();
        
        //En caso de que al enviar correo se de un error desconocido se recomienda comentar el código desde esta línea hasta el final de catch
        if(!isset($_SESSION["usuarioAdmin"])){
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
            } catch (Exception $e) {
                echo "Error al enviar el correo: {$mail->ErrorInfo}";
            }
        }

        $sentencia = mysqli_stmt_init($con);
        $sql = "INSERT into usuarios (nombre, apellidos, nomusu, clave, email, tel, ganancias, fechanac, imgusu, tipocu, marketing, tipousu) values (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        mysqli_stmt_prepare($sentencia, $sql);
        mysqli_stmt_bind_param($sentencia, "ssssssdsssss", $nombre, $apellidos, $nombreUsuario, $claveCifrada, $email, $telefono, $gananciasIniciales, $fechaNacFinal, $rutaFichero, $tipoCuenta, $marketing, $tipoUsuario);
        $res = mysqli_stmt_execute($sentencia) or die(mysqli_error($con));
        if(!isset($_SESSION["usuarioValidado"]) && !isset($_SESSION["usuarioAdmin"])){
            $_SESSION["usuarioValidado"] = $nombreUsuario;
        }
        mysqli_close($con);

        if(isset($_SESSION["usuarioAdmin"])){
            header("Location: usuarios.php?titulo=Éxito&mensaje=Usuario creado correctamente&tipoMensaje=success&colorIcono=ForestGreen");
            exit;
        }else if(isset($_SESSION["usuarioValidado"])){
            header("Location: index.php?titulo=Éxito&mensaje=Se ha enviado un correo al email indicado para validar su cuenta&tipoMensaje=success&colorIcono=ForestGreen");
            exit;
        }

    }else { ?>
        <div class="form-container">
            <fieldset style="width: auto; height: auto">
                <legend><span class="titulo">LotoPlus</span><img src="images/lotoplus.png" width="30px"><span class="titulo">CREAR CUENTA DE USUARIO</span>
                    <span id="titulo">(o <a href="#">inicia sesión en tu cuenta</a>)</span>
                </legend>
                <form action="<?= $_SERVER["PHP_SELF"] ?>" method="post" enctype="multipart/form-data">
                    <table>
                        <tr>
                            <td><input type="text" name="nombre" id="nombre" placeholder="Nombre" maxlength="45"
                                    value="<?= $nombre ?>"></td>
                            <td colspan="2"><label for="fechaNac">Fecha de nacimiento:</label><input type="date" name="fechaNac" id="fechaNac" placeholder="dd/mm/aaaa" value="<?= $errores["edad"] == false ? $fechaNac->format('Y-m-d') : "" ?>">
                                <span class="errores"><?= $errores["edad"] ?></span>
                            </td>
                        </tr>
                        <tr>
                            <td><input type="text" name="apellidos" id="apellidos" placeholder="Apellidos" maxlength="65"
                                    value="<?= $apellidos ?>"></td>
                            <td colspan="3"><label for="fotoPerfil">Imagen de perfil</label><input type="file" name="fotoPerfil" id="fotoPerfil" accept="image/jpeg, image/gif, image/png">
                                <span class="errores"><?= $errores["tamanyo"] ?></span>
                            </td>
                        </tr>
                        <tr>
                            <td><input type="text" name="nombreUsuario" id="nombreUsuario" placeholder="Nombre de usuario"
                                    value="<?= $errores["nombreUsuario"] == false ? $nombreUsuario : "" ?>"><br><span class="errores"><?= $errores["nombreUsuario"] ?></span><br><span class="errores"><?= $errores["nombreUsuarioRepetido"] ?></span></td>
                            <td colspan="3"><label for="tipoCuenta">Tipo de cuenta</label>
                                <select name="tipoCuenta" id="tipoCuenta">
                                    <option value="Gratuita" <?php if ($tipoCuenta == "Gratuita") echo "selected"; ?>>Gratuita</option>
                                    <option value="Suscripcion" <?php if ($tipoCuenta == "Suscripcion") echo "selected"; ?>>Suscripción</option>
                                </select><input type="number" name="gananciasIniciales" id="gananciasIniciales" placeholder="Ganancias Iniciales" value="<?= $gananciasIniciales ?>">
                            </td>
                        </tr>
                        <tr>
                            <td><input type="password" name="passwd" id="passwd" placeholder="Contraseña">
                                <button type="button" id="mostrarContrasenya">
                                    <img src="images/mostrarContrasenya.png" width="40px" alt="Icono de mostrar contraseña" id="iconoContrasenya">
                                </button><br><span class="errores"><?= $errores["contrasenya"] ?></span>
                            </td>
                            <td><input type="tel" name="telefono" id="telefono" placeholder="Móvil" required
                                    value="<?= $errores["telefono"] == false ? $telefono : "" ?>"><span class="errores"><?= $errores["telefono"] ?></span><br></td>
                                    
                                <?php
                                if(isset($_SESSION["usuarioAdmin"])){
                                ?>
                                    <label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Nivel de cuenta:</label>
                                    <select name="tipousu">
                                        <option value="n" <?php if($tipoUsuario == "n") echo "selected"; ?>>Normal</option>
                                        <option value="A" <?php if($tipoUsuario == "A") echo "selected"; ?>>Administrador</option>
                                    </select>
                                <?php
                                }
                                ?>
                        </tr>
                        <tr>
                            <td>
                                <span id="mensajeFortaleza" style="margin-right: 10px;"></span>
                                <div id="barra-fortaleza" style="margin-left: 5px; width: 74%; height: 10px; background-color: lightgray; border-radius: 5px;">
                                    <div id="fortaleza" style="height: 100%; width: 0%; transition: width 0.5s ease; border-radius: 5px;"></div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td rowspan="2"><input type="email" name="email" id="email" placeholder="Correo electrónico"
                                    value="<?= $errores["email"] == false ? $email : "" ?>"><br>
                                <span class="errores"><?= $errores["email"] ?></span>
                            </td>
                            <td><input type="checkbox" name="aceptaCondiciones" id="aceptaCondiciones" required
                                    <?php if ($aceptaCondiciones) echo "checked"; ?>><label for="aceptaCondiciones"
                                    id="labelCondiciones">Acepto las Condiciones de uso de LotoPlus</label></td>
                        </tr>
                        <tr>
                            <td><input type="checkbox" name="marketing" id="marketing" <?php if ($marketing === "S") echo "checked"; ?>>
                                <label for="marketing" id="labelMarketing">Me gustaría recibir novedades de marketing de LotoPlus por correo
                                    electrónico</label>
                            </td>
                        </tr>
                        <tr>
                        <td></td>
                        </tr>
                        <tr>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                        </tr>
                        <tr>
                            <td><input type="submit" name="enviar" value="CREAR CUENTA"></td>
                            <td colspan="2"><input type="reset" value="CANCELAR"></td>
                        </tr>
                    </table><br>
                </form>
            </fieldset>
        </div>
        <script src="js/mostrarContrasenya.js"></script>
        <script src="js/medirFortalezaContrasenya.js"></script>
        </body>
        </html>

<?php
    }
} else{
?>
    <div class="form-container">
        <fieldset style="width: 800px; height: 380px">
            <legend><span class="titulo">LotoPlus</span><img src="images/lotoplus.png" width="30px"><span class="titulo">CREAR CUENTA DE USUARIO</span><span id="titulo">(o <a href="formularioIniciarSesion.php">inicia sesión en tu cuenta</a>)</span></legend>
            <form action="<?= $_SERVER["PHP_SELF"] ?>" method="post" enctype="multipart/form-data">
                <table>
                    <tr>
                        <td><input type="text" name="nombre" id="nombre" placeholder="Nombre" maxlength="45"></td>
                        <td colspan="2"><label for="fechaNac">Fecha de nacimiento:</label><input type="date" name="fechaNac" id="fechaNac" placeholder="dd/mm/aaaa" required></td>
                    </tr>
                    <tr>
                        <td><input type="text" name="apellidos" id="apellidos" placeholder="Apellidos" maxlength="65"></td>
                        <td colspan="3"><label for="fotoPerfil">Imagen de perfil</label><input type="file" name="fotoPerfil" id="fotoPerfil" accept="image/jpeg, image/gif, image/png"></td>
                    </tr>
                    <tr>
                        <td><input type="text" name="nombreUsuario" id="nombreUsuario" placeholder="Nombre de usuario" required></td>
                        <td colspan="3"><label for="tipoCuenta">Tipo de cuenta</label>
                            <select name="tipoCuenta" id="tipoCuenta">
                                <option value="Gratuita">Gratuita</option>
                                <option value="Suscripcion">Suscripción</option>
                            </select>
                            <input type="number" name="gananciasIniciales" id="gananciasIniciales" placeholder="Ganancias Iniciales">
                        </td>
                    </tr>
                    <tr>
                        <td><input type="password" name="passwd" id="passwd" placeholder="Contraseña" required>
                            <button type="button" id="mostrarContrasenya">
                                <img src="images/mostrarContrasenya.png" width="40px" alt="Icono de mostrar contraseña" id="iconoContrasenya">
                            </button>
                        </td>
                        <td><input type="tel" name="telefono" id="telefono" placeholder="Móvil" required>
                        
                            <?php
                            if(isset($_SESSION["usuarioAdmin"])){
                            ?>
                                <label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Nivel de cuenta:</label>
                                <select name="tipousu">
                                    <option value="n">Normal</option>
                                    <option value="A">Administrador</option>
                                </select>
                            <?php
                            }
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <span id="mensajeFortaleza" style="margin-right: 10px; margin-left: 5px;"></span>
                            <div id="barra-fortaleza" style="margin-left: 5px; width: 74%; height: 10px; background-color: lightgray; border-radius: 5px;">
                                <div id="fortaleza" style="height: 100%; width: 0%; transition: width 0.5s ease; border-radius: 5px;"></div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td rowspan="2"><input type="email" name="email" id="email" placeholder="Correo electrónico" required></td>
                        <td><input type="checkbox" name="aceptaCondiciones" id="aceptaCondiciones" required><label for="aceptaCondiciones"
                                id="labelCondiciones">Acepto las Condiciones de uso de LotoPlus</label></td>
                    </tr>
                    <tr>
                        <td><input type="checkbox" name="marketing" id="marketing">
                            <label for="marketing" id="labelMarketing">Me gustaría recibir novedades de marketing de LotoPlus por correo
                                electrónico</label>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                    </tr>
                    <tr>
                        <td><input type="submit" name="enviar" value="CREAR CUENTA"></td>
                        <td colspan="2"><input type="reset" value="CANCELAR"></td>
                    </tr>
                </table><br>
            </form>
        </fieldset>
    </div>
    <script src="js/mostrarContrasenya.js"></script>
    <script src="js/medirFortalezaContrasenya.js"></script>
<?php
}
require("includes/pie.php");
?>