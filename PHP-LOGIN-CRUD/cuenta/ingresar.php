<?php
	include "../funciones/funciones.php";
	session_start();

	if (!isset($_SESSION['usuario'])) {
		die("Error -debe <a href='../index.php'>identificarse</a>");
	}

	if (isset($_POST['ingresar'])) {
		$fecha = $_POST['fecha'];
		$concepto = $_POST['concepto'];
		$cantidad = $_POST['cantidad'];
		$login=$_SESSION['usuario'];
		$codMov=get_cod_ultimo_mov("conta2");
		$sql="INSERT INTO movimientos VALUES('$codMov','$login','$fecha','$concepto','$cantidad')";
		realizar_operacion("conta2",$sql);
	}
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8">
	<title>Ingreso</title>
	<link rel="stylesheet" type="text/css" href="../css/estilos.css">
</head>

<body>
	<header>
		<h1>Gestion Personal: Ingreso</h1>
		<div id="nombre-usuario-cabecera">
			<i>Bienvenid@</i> <b><?php  ?></b>
		</div>
	</header>
	<nav>
		<span class="desplegable">
			<a href="./?<?php  ?>">Mi Cuenta</a>
			<div>
				<a href="movimientos.php">Ultimos Movimientos</a>
				<a href="ingresar.php">Contabilizar un ingreso</a>
				<a href="pagar.php">Contabilizar un Gasto</a>
				<a href="devolver.php">Eliminar un movimiento</a>
				<a href="../logoff.php">Salir</a>
			</div>
		</span>
		&gt; Contabilizar un ingreso
	</nav>
	<main>
		<form method="post" class="formulario" action="">
			<table>
				<tfoot>
					<tr>
						<td colspan="2">
							<?php
							if (!empty($error)) {
								echo '<div class="error"><b>!</b>' . $error . '</div>';
							}
							?>
						</td>
					</tr>
				</tfoot>
				<tbody>
					<tr>
						<td><label>Fecha:</label></td>
						<td>
							<input type="date" name="fecha" size="10" placeholder="aaaa-mm-dd" maxlength="10" required>
						</td>
					</tr>
					<tr>
						<td><label>Concepto:</label></td>
						<td>
							<input type="text" name="concepto" size="20" placeholder="Descripción Movimiento" maxlength="20" required>
						</td>
					</tr>
					<tr>
						<td><label>Cantidad:</label></td>
						<td>
							<input type="number" name="cantidad" min="0" step="0.01" required>
							<input type="submit" name="ingresar" value="Ingresar">
						</td>
					</tr>
				</tbody>
			</table>
		</form>
	</main>
</body>

</html>