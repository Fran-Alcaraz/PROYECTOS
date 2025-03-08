<?php
require("includes/cabecera.php");
session_destroy();
header("Location: index.php");
require("includes/pie.php");
?>