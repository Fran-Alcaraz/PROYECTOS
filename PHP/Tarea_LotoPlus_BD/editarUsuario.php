<?php
$titulo = "Editar Usuario | LotoPlus";
require("includes/cabecera.php");
/*Si se ha pulsado el botón submit guardo toda la información en variables para facilitar su acceso y, en caso contrario, muestro
        el formulario*/

if (isset($_POST['enviar'])) {
    $idusuario = $_POST["idusuario"];
    $cont = $_POST["cont"];
    $nombre = $_POST["nombre"];
    $apellidos = $_POST["apellidos"];
    $nombreUsuario = $_POST["nombreUsuario"];
    $nivelFortaleza = 0;
    $email = $_POST["email"];
    $fechaNac = new DateTime($_POST["fechaNac"]);
    $tipoCuenta = $_POST["tipoCuenta"];
    $gananciasIniciales = $_POST["gananciasIniciales"];
    $telefono = $_POST["telefono"];
    $aceptaCondiciones = isset($_POST["aceptaCondiciones"]) ? $_POST["aceptaCondiciones"] : "N";
    $marketing = isset($_POST["marketing"]) ? "S" : "N";
    $rutaFichero = "";
    $tipoUsuario = "normal";
    $fechaNacFinal = $fechaNac->format("Y-m-d");

    //Creo una variable para comprobar si ha habido algún error en el formulario
    $error = false;

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
        /*Compruebo que el archivo se haya subido correctamente. Si ya tiene foto y no se quiere cambiar esta se mantiene la anterior sin 
        necesidad de subir de nuevo la que ya tenía el usuario*/
        if (!is_uploaded_file($_FILES['fotoPerfil']['tmp_name'])) {
            $rutaFichero = $_POST["urlFoto"];
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
            $rutaFichero = "uploads/".$nombreFichero;
        } else {
            
        }

        $fechaNacEditada = $fechaNac->format("Y-m-d");
        $con = conectar();
        $sentencia = mysqli_stmt_init($con);
        $sql = "UPDATE usuarios SET nombre = ?, apellidos = ?, nomusu = ?, clave = ?, email = ?, tel = ?, ganancias = ?, fechanac = ?, imgusu = ?,
        tipocu = ?, marketing = ? WHERE idusuario = ?";
        mysqli_stmt_prepare($sentencia, $sql);
        mysqli_stmt_bind_param($sentencia, "ssssssdssssi", $nombre, $apellidos, $nombreUsuario, $cont, $email, $telefono, $gananciasIniciales, $fechaNacEditada, $rutaFichero,  $tipoCuenta, $marketing, $idusuario);
        $res = mysqli_stmt_execute($sentencia) or die(mysqli_error($con));
        mysqli_close($con);
        if(isset($_SESSION["usuarioAdmin"])){
            header("Location: usuarios.php?titulo=Éxito&mensaje=Usuario actualizado correctamente&tipoMensaje=success&colorIcono=ForestGreen");
        }else if(isset($_SESSION["usuarioValidado"])){
            $_SESSION["usuarioValidado"] = $nombreUsuario;
            header("Location: index.php?titulo=Éxito&mensaje=Usuario actualizado correctamente&tipoMensaje=success&colorIcono=ForestGreen");
        }
        exit;

    }else { ?>
        <div class="form-container">
            <fieldset style="width: 800px; height: auto">
                <legend><span class="titulo">LotoPlus</span><img src="images/lotoplus.png" width="30px"><span class="titulo">EDITAR CUENTA DE USUARIO</span>
                </legend>
                <form action="<?= $_SERVER["PHP_SELF"] ?>" method="post" enctype="multipart/form-data">
                <input type="hidden" name="idusuario" value="<?php echo $idusuario ?>">
                <input type="hidden" name="cont" value="<?php echo $cont ?>">
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
                            <input type="hidden" name="urlFoto" value="<?php echo $foto?>">
                            <td colspan="3"><label for="fotoPerfil">Imagen de perfil</label><input type="file" name="fotoPerfil" id="fotoPerfil" accept="image/jpeg, image/gif, image/png">
                                <span class="errores"><?= $errores["tamanyo"] ?></span>
                            </td>
                        </tr>
                        <tr>
                            <td><input type="text" name="nombreUsuario" id="nombreUsuario" placeholder="Nombre de usuario"
                                    value="<?= $errores["nombreUsuario"] == false ? $nombreUsuario : "" ?>"><br><span class="errores"><?= $errores["nombreUsuario"] ?></span></td>
                            <td colspan="3"><label for="tipoCuenta">Tipo de cuenta</label>
                                <select name="tipoCuenta" id="tipoCuenta">
                                    <option value="Gratuita" <?php if ($tipoCuenta == "Gratuita") echo "selected"; ?>>Gratuita</option>
                                    <option value="Suscripcion" <?php if ($tipoCuenta == "Suscripcion") echo "selected"; ?>>Suscripción</option>
                                </select><input type="number" name="gananciasIniciales" id="gananciasIniciales" placeholder="Ganancias Iniciales" value="<?= $gananciasIniciales ?>">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <a href="modificarContrasenya.php" class="btn-modificar-contrasenya">Cambiar contraseña</a>
                            </td>
                            <td><input type="tel" name="telefono" id="telefono" placeholder="Móvil" required
                                    value="<?= $errores["telefono"] == false ? $telefono : "" ?>"><span class="errores"><?= $errores["telefono"] ?></span>
                                <?php
                                if(isset($_SESSION["usuarioAdmin"])){
                                ?>
                                    <label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Nivel de cuenta:</label>
                                    <select name="tipousu">
                                        <option value="n" <?php if($tip == "n") echo "selected"; ?>>Normal</option>
                                        <option value="A" <?php if($tip == "A") echo "selected"; ?>>Administrador</option>
                                    </select>
                                <?php
                                }
                                ?>
                            </td>
                        </tr>
                        <tr>
                        </tr>
                        <tr>
                            <td rowspan="2"><input type="email" name="email" id="email" placeholder="Correo electrónico"
                                    value="<?= $errores["email"] == false ? $email : "" ?>"><br>
                                <span class="errores"><?= $errores["email"] ?></span>
                            </td>
                        </tr>
                        <tr>
                            <td><input type="checkbox" name="marketing" id="marketing" <?php if ($marketing) echo "checked"; ?>>
                                <label for="marketing" id="labelMarketing">Me gustaría recibir novedades de marketing de LotoPlus por correo
                                    electrónico</label>
                            </td>
                        </tr>
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
                        <tr>
                            <td><input type="submit" name="enviar" value="ACTUALIZAR CUENTA"></td>
                            <td colspan="2"><input type="reset" value="CANCELAR"></td>
                        </tr>
                    </table><br>
                </form>
            </fieldset>
        </div>
        <script src="js/mostrarContrasenya.js"></script>
        <script src="js/medirFortalezaContrasenya.js"></script>
        </body>

        </html><?php
        }
} else if(isset($_SESSION["usuarioValidado"]) || isset($_SESSION["usuarioAdmin"])){

    $idusuario = $_POST["editar"];
    $con = conectar();
    $sqlEditar = "SELECT * FROM usuarios WHERE idusuario = $idusuario";
    $resultado = mysqli_query($con, $sqlEditar) or die(mysqli_error($con));

    $fila = mysqli_fetch_array($resultado);

    $nom = $fila["nombre"];
    $ape = $fila["apellidos"];
    $usu = $fila["nomusu"];
    $cont = $fila["clave"];
    $ema = $fila["email"];
    $mov = $fila["tel"];
    $gan = $fila["ganancias"];
    $fec = $fila["fechanac"];
    $foto = $fila["imgusu"];
    $cue = $fila["tipocu"];
    $mar = $fila["marketing"];
    $tip = $fila["tipousu"];

    mysqli_free_result($resultado);
    mysqli_close($con);

                ?>
    <div class="form-container">
        <fieldset style="width: 800px; height: 380px">
            <legend><span class="titulo">LotoPlus</span><img src="images/lotoplus.png" width="30px"><span class="titulo">EDITAR CUENTA DE USUARIO</span></legend>
            <form action="<?= $_SERVER["PHP_SELF"] ?>" method="post" enctype="multipart/form-data">
                <input type="hidden" name="idusuario" value="<?php echo $idusuario ?>">
                <input type="hidden" name="cont" value="<?php echo $cont ?>">
                <table>
                    <tr>
                        <td><input type="text" name="nombre" id="nombre" value="<?php echo $nom ?>" maxlength="45"></td>
                        <td colspan="2"><label for="fechaNac">Fecha de nacimiento:</label><input type="date" name="fechaNac" id="fechaNac" value="<?php echo $fec ?>" required></td>
                    </tr>
                    <tr>
                        <td><input type="text" name="apellidos" id="apellidos" value="<?php echo $ape ?>" maxlength="65"></td>
                        <input type="hidden" name="urlFoto" value="<?php echo $foto?>">
                        <td colspan="3"><label for="fotoPerfil">Imagen de perfil</label><input type="file" name="fotoPerfil" id="fotoPerfil" accept="image/jpeg, image/gif, image/png"></td>
                    </tr>
                    <tr>
                        <td><input type="text" name="nombreUsuario" id="nombreUsuario" value="<?php echo $usu ?>" required></td>
                        <td colspan="3"><label for="tipoCuenta">Tipo de cuenta</label>
                            <select name="tipoCuenta" id="tipoCuenta">

                                <?php
                                if($cue == "Gratuita"){
                                ?>

                                    <option value="Gratuita">Gratuita</option>
                                    <option value="Suscripcion">Suscripción</option>

                                <?php
                                }else{
                                ?>

                                    <option value="Gratuita">Gratuita</option>
                                    <option value="Suscripcion" selected>Suscripción</option>

                                <?php
                                }
                                ?>

                            </select>
                            <input type="number" name="gananciasIniciales" id="gananciasIniciales" value="<?php echo $gan ?>">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <a href="modificarContrasenya.php" class="btn-modificar-contrasenya">Cambiar contraseña</a>
                        </td>
                        <td><input type="tel" name="telefono" id="telefono" value="<?php echo $mov ?>" required>
                                <?php
                                if(isset($_SESSION["usuarioAdmin"])){
                                ?>
                                    <label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Nivel de cuenta:</label>
                                    <select name="tipousu">
                                        <option value="n" <?php if($tip == "n") echo "selected"; ?>>Normal</option>
                                        <option value="A" <?php if($tip == "A") echo "selected"; ?>>Administrador</option>
                                    </select>
                                <?php
                                }
                                ?>
                        </td>
                    </tr>
                    <tr>
                    </tr>
                    <tr>
                        <td rowspan="2"><input type="email" name="email" id="email" value="<?php echo $ema ?>" required></td>
                    </tr>
                    <tr>
                        <td>
                            
                                <?php
                                if($mar == "S"){
                                ?>

                                <input type="checkbox" name="marketing" id="marketing" checked>

                                <?php
                                }else{
                                ?>

                                <input type="checkbox" name="marketing" id="marketing">

                                <?php
                                }
                                ?>
                        
                            <label for="marketing" id="labelMarketing">Me gustaría recibir novedades de marketing de LotoPlus por correo
                                electrónico</label>
                        </td>
                    </tr>
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
                    <tr>
                        <td><input type="submit" name="enviar" value="ACTUALIZAR CUENTA"></td>
                        <td colspan="2"><input type="reset" value="CANCELAR"></td>
                    </tr>
                </table><br>
            </form>
        </fieldset>
    </div>
    <script src="js/mostrarContrasenya.js"></script>
    <script src="js/medirFortalezaContrasenya.js"></script>
<?php
}else {?>
    <div class="container-principal">       
        <div class="container-aviso">
            <h1>Debes iniciar sesión como usuario o administrador para acceder a esta sección</h1>
            <p>Para ver tu información <a href="formularioIniciarSesion.php">inicia sesión</a></p>
            <p>Si no dispones de una cuenta de usuario o administrador <a href="index.php">vuelve al inicio</a></p>
        </div>
    </div>
<?php
}
require("includes/pie.php");
?>