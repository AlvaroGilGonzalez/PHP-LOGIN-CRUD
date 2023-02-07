<?php
	include "../funciones/funciones.php";
	session_start();

	if (!isset($_SESSION['usuario'])) {
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
		<h1>Gestión Personal: Eliminar</h1>
		<div id="nombre-usuario-cabecera">
			<i>Bienvenid@</i> <b><?php  ?></b>
		</div>
	</header>
	<nav>
		<span class="desplegable">
			<a href="./?<?php  ?>">Mi Cuenta</a>
			<div>
				<a href="movimientos.php">Ultimos Movimientos</a>
				<a href="ingresar.php">Contabilizar un Ingreso</a>
				<a href="pagar.php">Contabilizar un Gasto</a>
				<a href="devolver.php">Eliminar un movimiento</a>
				<a href="../logoff.php">Salir</a>
			</div>
		</span>
		&gt; Eliminar un movimiento
	</nav>
	<main>
		<?php

		?>
		<table class="tabla">
			<thead>
				<tr>
					<th>Fecha</th>
					<th>Concepto</th>
					<th>Cantidad</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				<?php
					mostrar_tabla_devoluciones("conta2",$_SESSION['usuario']);
				?>
			</tbody>
			<tfoot>
				<tr>
					<th>Numero de Movimientos:<?php echo mostrar_num_movimientos("conta2",$_SESSION['usuario']) ?></th>
					<th colspan="3"></th>
				</tr>
			</tfoot>
		</table>
		<?php  ?>
	</main>
</body>
</html>