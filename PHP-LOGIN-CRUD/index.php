<?php
    include("funciones/funciones.php");

    if(isset($_POST['form_login'])){
        $usuario=$_POST['usuario'];
        $clave=$_POST['clave'];

		if(comprobar_existe_usuario("conta2",$usuario)){
			$password_bd=obtener_clave("conta2",$usuario);
			if(password_verify($clave,$password_bd)){
				session_start();
            	$_SESSION['usuario']=$usuario;
            	header("Location:cuenta/index.php");
			}else{
				$error="La clave introducida no es correcta";
			}
		}else{
			$error="No existe ningun usuario con el login introducido";
		}
    }

    if(isset($_POST['form_admin_login'])){
        $usuario=$_POST['usuario'];
        $clave=$_POST['clave'];
        if(admin_verify($usuario,$clave)){
            session_start();
            $_SESSION['usuario']=$usuario;
            header("Location:admin/index.php");
        }else{
            $error="Credenciales de usuario admin incorrectas";
        }
    }
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Contabilidad Personal</title>
	<link rel="stylesheet" type="text/css" href="css/estilos.css">
</head>
<body id="pagina-login">
	<header><h1>Gastos Personales</h1></header>
	<nav>Contabilidad personal</nav>
	<main>
		<fieldset class="mini-formulario"><legend>Iniciar Sesión</legend>
			<?php
			if (isset($error)) {
				echo "<div class='error'>$error</div>";
			}
			?>
			<form method="post">
				<div class="input-labeled">
					<label>Usuario:</label>
					<input type="text" name="usuario" required maxlength="10">
				</div>


				<div class="input-labeled">
					<label>Clave:</label>
					<input type="password" name="clave" required maxlength="20">
				</div>
				<input type="submit" name="form_login" value="Gestionar mi cuenta">
				<hr>
				<input type="submit" name="form_admin_login" value="Gestionar Usuarios">
			</form>
		</fieldset>
	</main>
</body>
</html>
