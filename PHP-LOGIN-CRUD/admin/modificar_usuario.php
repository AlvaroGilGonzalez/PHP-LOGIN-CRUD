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
	<title>Modificar Usuarios</title>
	<link rel="stylesheet" type="text/css" href="../css/estilos.css">
</head>
<body id="pagina-login">
	<header><h1>Modificar Usuarios</h1></header>
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
		&gt; Modificar Usuario
	</nav>
	<main>
		<fieldset class="mini-formulario"><legend>Modificar Usuario</legend>
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
				<input type="submit" name="modificar" value="Modificar">

                <?php
                    if(isset($_POST['modificar'])){
                        $datos=informacionBorrado("conta2",$usuario);
                ?>

                <div class="input-labeled">
					<label>Login:</label>
					<input type="text" name="login" required maxlength="10" readonly value="<?php echo $datos[0] ?>">
				</div>
				<div class="input-labeled">
					<label>Clave:</label>
					<input type="password" name="password" placeholder="**********" maxlength="20" value="<?php  ?>">
				</div>
				<div class="input-labeled">
					<label>Repite Clave:</label>
					<input type="password" name="repassword" placeholder="**********" maxlength="20" value="<?php  ?>">
				</div>
				<div class="input-labeled">
					<label>Nombre:</label>
					<input type="text" name="nombre" required maxlength="30" value="<?php echo $datos[1] ?>">
				</div>
				<div class="input-labeled">
					<label>Fecha Nacimiento:</label>
					<input type="date" name="fNacimiento" placeholder="aaaa-mm-dd" required maxlength="10" value="<?php echo $datos[2] ?>">
				</div>
				<input type="submit" name="confirmamodificar" value="Confirmar Modificaciones">

                <?php
                }
                if(isset($_POST['confirmamodificar'])){
                    $password=$_POST['password'];
                    $clave=crypt($password,'XC');
                    $repassword=$_POST['repassword'];
                    $reclave=crypt($repassword,'XC');
                    $nombre=$_POST['nombre'];
                    $fNacimiento=$_POST['fNacimiento'];

                    if(strcmp($clave,$reclave)!=0){
                        $error="Las contraseñas deben ser iguales.<br>";
                    }else{
                        $sql="UPDATE usuarios SET password='$clave',nombre='$nombre',fNacimiento='$fNacimiento' WHERE login='$usuario'";
                        realizar_operacion("conta2",$sql);
                        $correcto="Usuario modificado correctamente";
                    }

                }
                if (isset($error)) {echo "<div class='error'><b>!</b>$error</div>";}
                if (isset($correcto)) {
                    echo "<div class='correcto'><b>!</b>$correcto</div>";
                     //Si la operacion es correcta mostramos el mensaje y actualizamos la pagina pasdos 4 segundos para ver los datos actualizados
                    header("refresh:5;modificar_usuario.php");
                }
                ?>

            </form>
		</fieldset>
	</main>
	<?php ?>
</body>
</html>