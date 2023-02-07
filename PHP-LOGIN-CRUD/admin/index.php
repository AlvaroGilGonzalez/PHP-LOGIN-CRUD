<?php
    include("../funciones/funciones.php");
    session_start();

    if(!isset($_SESSION['usuario'])){
        die("Error - debe <a href='../index.php'>Identificarse</a>");
    }else{
        $usuario=$_SESSION['usuario'];
        if($usuario!='daw'){
            die("Error - Solo el usuario admin puede acceder a esta pagina <a href='index.php'>Identificarse</a>");
        }
    }

?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Gestión de Usuarios</title>
        <link rel="stylesheet" type="text/css" href="../css/estilos.css">
    </head>
    <body>
		<header><h1>Gestión de Usuarios</h1></header>
		<nav>Administrar Usuarios</nav>
        <main>
			<div id="menu">
				<a href="nuevo_usuario.php">Nuevo Usuario</a>
				<a href="modificar_usuario.php?">Modificar Usuario</a>
				<a href="borrar_usuario.php">Borrar Usuario</a>
				<a href="../logoff.php">Salir</a>
			</div>
		</main>
    </body>
</html>