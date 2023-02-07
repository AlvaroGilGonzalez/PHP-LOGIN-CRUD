<?php
	include "../funciones/funciones.php";
	session_start();
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
		<h1>Gestión Personal: Movimientos</h1>
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
		&gt; Últimos Movimientos
	</nav>
	<main>
		<?php

		?>
		<table class="tabla">
			<thead>
				<tr>
					<th>CodMov</th>
					<th>Fecha</th>
					<th>Concepto</th>
					<th>Cantidad</th>
					<th>Saldo Contable</th>
				</tr>
			</thead>
			<tbody>
				<?php
				mostrar_movimientos("conta2", $_SESSION['usuario']);
				?>
			</tbody>
			<tfoot>
				<tr>
					<th>Nº Mov</th>
					<th><?php echo mostrar_num_movimientos("conta2",$_SESSION['usuario']) ?></th>
					<th colspan="2">Saldo Actual:</th>
					<th><?php echo calcular_saldo_actual("conta2",$_SESSION['usuario']) ?></th>
				</tr>
			</tfoot>
		</table>
		<?php  ?>
	</main>
</body>

</html>