<?php
    include "../funciones/funciones.php";
    session_start();
    if (!isset($_SESSION['usuario'])) {
		die("Error -debe <a href='../index.php'>identificarse</a>");
	}
    $codigo=$_GET['codMov'];
    $sql="DELETE FROM movimientos WHERE codigoMov='$codigo'";
    realizar_operacion("conta2",$sql);
    header("Location:devolver.php");
?>