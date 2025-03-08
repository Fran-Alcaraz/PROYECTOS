<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title><?= $titulo ?></title>
</head>
<body>
    <?php
        require("config.php");
        require("funciones.php");
        session_start();
    ?>
    <header>
        <div class="menu-container">
            <div class="menu">
                <nav>
                    <ul>
                        <?php
                        if(isset($_SESSION["usuarioAdmin"])){
                            ?>
                            <li><a href="usuarios.php">Usuarios</a></li>
                            <?php
                        }
                        
                        if(isset($_SESSION["usuarioValidado"]) || isset($_SESSION["usuarioAdmin"])){?>
                            <li><a href="participaciones.php">Participaciones</a></li>
                        <?php
                        }
                        ?>
                        <a href="index.php"><img src="images/lotoplus.png" alt="Logo de LotoPlus" width="55px"></a>
                        <?php
                        
                        if(isset($_SESSION["usuarioValidado"]) || isset($_SESSION["usuarioAdmin"])){
                            ?>
                            <li><a href="premios.php">Premios</a></li>
                            <?php
                        }

                        if(isset($_SESSION["usuarioAdmin"])){
                            ?>
                            <li><a href="sorteos.php">Sorteos</a></li>
                            <?php
                        }
                        ?>
                    </ul>
                    
                </nav>
            </div>
        </div>
    </header>