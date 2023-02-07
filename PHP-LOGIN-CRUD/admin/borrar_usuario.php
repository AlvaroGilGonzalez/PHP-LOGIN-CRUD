<?php
    include "../funciones/funciones.php";
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
	<title>Borrar Usuarios</title>
	<link rel="stylesheet" type="text/css" href="../css/estilos.css">
</head>
<body id="pagina-login">
	<header><h1>Borrar Usuarios</h1></header>
	<nav>
		<span class="desplegable">
			<a href="./?<?php  ?>">Administrar Usuarios</a>
			<div>
				<a href="nuevo_usuario.php">Nuevo Usuario</a>
				<a href="modificar_usuario.php">Modificar Usuario</a>
				<a href="borrar_usuario.php">Borrar Usuario</a>
				<a href="../logoff.php">Salir</a>
			</div>
		</span>
		&gt; Borrar Usuario
	</nav>
	<main>
		<fieldset class="mini-formulario"><legend>Borrar Usuario</legend>
			<form method="post" action="">
				<label>Selecciona Usuario</label>
				<select name="select_login" required>
                <?php
                    if (isset($_POST['select_login'])){
                        $usuario = $_POST['select_login'];
                    }
                    // Rellenamos el desplegable con los datos de todos los usuarios
                    $conexion=conectarBD("conta2");
                    $sql="SELECT login FROM usuarios";
                    $resultado = $conexion->query($sql);
                    if ($resultado) {
                        $row = $resultado->fetch();
                        while ($row != null) {
                            echo "<option value='${row['login']}'";
                            // Si se recibió un login de usuario lo seleccionamos
                            // en el desplegable usando selected='true'
                            if (isset($usuario) && $usuario == $row['login']){
                                echo " selected='true'";
                            }
                            echo ">${row['login']}</option>";
                            $row = $resultado->fetch();
                        }
                    }
                    unset($conexion);
                ?>
				</select>
				<input type="submit" name="eliminar" value="Borrar">

                <?php
                    if(isset($_POST['eliminar'])){
                        $datos=informacionBorrado("conta2",$usuario);
                        //Si el usuario tiene movs asociados debemos eliminarlos antes asi que controlamos esa posibilidad
                        if(tiene_movimientos_asociados("conta2",$usuario)){
                            echo "<p>El usuario seleccionado tiene movimientos asociados, si lo elimina también se eliminaran dichos movimientos asociados. ¿Confirma borrar el usuario y todos sus movimientos?</p>";
                        }else{
                            echo "<p>¿Confirma borrar el siguiente usuario?</p>";
                        }
                ?>

				<div class="input-labeled">
					<label>Login:</label>
					<input type="text" readonly name="login" value="<?php echo $datos[0]  ?>">
				</div>
				<div class="input-labeled">
					<label>Nombre:</label>
					<input type="text" readonly value="<?php echo $datos[1] ?>">
				</div>
				<div class="input-labeled">
					<label>Fecha Nacimiento:</label>
					<input type="text" readonly value="<?php  echo $datos[2] ?>">
				</div>
				<input type="submit" name="confirmaborrar" value="Borrar">
				<input type="submit" value="Cancelar">

                <?php
                }
                //Si el usuario tiene movs asociados debemos eliminarlos antes de eliminar a dicho usuario
                if(isset($_POST['confirmaborrar'])&& (tiene_movimientos_asociados("conta2",$usuario))){
                    $sql="DELETE FROM usuarios WHERE login='$usuario'";
                    eliminar_movs_asociados("conta2",$usuario);
                    realizar_operacion("conta2",$sql);
                    $correcto="Usuario eliminado correctamente";
                }

                if(isset($_POST['confirmaborrar'])&& (!tiene_movimientos_asociados("conta2",$usuario))){
                    $sql="DELETE FROM usuarios WHERE login='$usuario'";
                    realizar_operacion("conta2",$sql);
                    $correcto="Usuario eliminado correctamente";
                }

                if (isset($error)) {echo "<div class='error'><b>!</b>$error</div>";}
                if (isset($correcto)) {
                    echo "<div class='correcto'><b>!</b>$correcto</div>";
                     //Si la operacion es correcta mostramos el mensaje y actualizamos la pagina pasdos 4 segundos para ver los datos actualizados
                    header("refresh:5;borrar_usuario.php");
                }

                ?>

            </form>
		</fieldset>
	</main>
	<?php ?>
</body>
</html>