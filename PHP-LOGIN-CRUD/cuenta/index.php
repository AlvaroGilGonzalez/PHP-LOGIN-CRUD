<?php
	 include '../funciones/funciones.php';
	 //Recuperar la sesion
	 session_start();

	 //Comprobamos que el usuario se ha autentificado
	 if(!isset($_SESSION['usuario'])){
	   die("Error -debe <a href='../index.php'>identificarse</a>");
	 }
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Gestión Personal</title>
	<link rel="stylesheet" type="text/css" href="../css/estilos.css">
</head>
<body>
	<header>
		<h1>Gestión Personal</h1>
		<div id="nombre-usuario-cabecera">
			<i>Bienvenid@</i> <b><?php echo $_SESSION['usuario']  ?></b>
		</div>
	</header>
	<nav>Mi Cuenta</nav>
	<main>
		<div id="menu">
			<a href="movimientos.php">Últimos Movimientos</a>
			<a href="ingresar.php">Contabilizar un Ingreso</a>
			<a href="pagar.php">Contabilizar un Gasto</a>
			<a href="devolver.php">Eliminar un movimiento</a>
			<a href="../logoff.php">Salir</a>
		</div>
	</main>
</body>
</html>