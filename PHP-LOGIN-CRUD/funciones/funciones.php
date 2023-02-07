<?php

    //--------------------Funcion general para conectarse a la base de datos-------------------------------------------------------------------------

    function conectarBD($base){
        try {
            $conexion = new PDO("mysql:host=localhost;dbname=" . $base, "root", "");
            $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
        return $conexion;
    }

    //----------------------------Funciones utilizadas para el control del login de los usuarios y el login del admin-----------------------------------------------------

    function comprobar_existe_usuario($base,$login){
        $conexion=conectarBD($base);
        $sql="SELECT login FROM usuarios WHERE login='$login' ";
        if($resultado=$conexion->query($sql)){
            $fila=$resultado->fetch();
            unset($resultado);
            if($fila!=null){
                return true;
            }else{
                return false;
            }
        }
        unset($conexion);
    }

    function obtener_clave($base,$login){
        try{
            $conexion=conectarBD($base);
            $sql="Select password from usuarios where login='$login'";
            if($resultado=$conexion->query($sql)){
                $fila=$resultado->fetch();
                if($fila!=null){
                    unset($resultado);
                    return $fila['password'];
                }
            }
        }catch(PDOException $e){
            $error=$e->getCode();
            $anuncio=$e->getMessage();
            die("Error".$anuncio." ".$error);
        }

    }

    function admin_verify($login,$password){
        if($login=='daw' && $password=='daw'){
            return true;
        }else{
            return false;
        }
    }

    //----------------Para todas las operaciones de actualizacion vamos a utilizar una misma funcion que realice la operacion-------------------------------------

    function realizar_operacion($base,$sql){
        $conexion=conectarBD($base);
        try{
            $conexion->exec($sql);
            return true;
        }catch(PDOException $e){
            $error = $e->getCode();
            $mensaje = $e->getMessage();
            return false;
        }
        unset($conexion);
    }

    //-----------------Funciones utilizados por el admin para crear, modificar y eliminar usuarios------------------------------------------------

    function crear_nuevo_usuario($base,$login,$clave,$nombre,$fNacimiento,$presupuesto){
        $clave=crypt($clave,'XC');
        $conexion=conectarBD($base);
        $sql="INSERT INTO usuarios VALUES('$login','$clave','$nombre','$fNacimiento',$presupuesto)";
        try{
            $conexion->exec($sql);
            return true;
        }catch(PDOException $e){
            $error = $e->getCode();
            $mensaje = $e->getMessage();
            return false;
        }
        unset($conexion);
    }

    function informacionBorrado($base,$login){
        $conexion=conectarBD($base);
        $sql="SELECT login,nombre,fNacimiento FROM usuarios WHERE login='$login' ";
        $datos=[];
        if($resultado=$conexion->query($sql)){
            $fila=$resultado->fetch();
            while($fila!=null){
                array_push($datos,$fila['login']);
                array_push($datos,$fila['nombre']);
                array_push($datos,$fila['fNacimiento']);
                $fila=$resultado->fetch();
            }
        }
        unset($conexion);
        return $datos;
    }

    function tiene_movimientos_asociados($base,$login){
        try{
            $conexion=conectarBD($base);
            $sql="SELECT * FROM movimientos WHERE loginUsu='$login'";
            $resultado=$conexion->query($sql);
            if($resultado){
                $row=$resultado->fetch();
                if($row!=null){
                    return true;
                }else{
                    return false;
                }

            }else{
                return false;
            }
        }catch(PDOException $e){
            return false;
        }
        unset($conexion);
    }

    function eliminar_movs_asociados($base,$login){
        $conexion=conectarBD($base);
        $sql="DELETE FROM movimientos WHERE loginUsu='$login'";
        try{
            $conexion->exec($sql);
            return true;
        }catch(PDOException $e){
            $error = $e->getCode();
            $mensaje = $e->getMessage();
            return false;
        }
        unset($conexion);
    }

    //----------------------Funciones utilizadas para mostrar los movimientos de un usuario------------------------------------------------

    function mostrar_movimientos($base, $login){
        try {
            $conexion = conectarBD($base);
            $sql = "SELECT codigoMov,fecha,concepto,cantidad,presupuesto FROM movimientos INNER JOIN usuarios ON loginUsu=login WHERE login='$login'";
            if ($resultado = $conexion->query($sql)) {
                $fila = $resultado->fetch();
            if ($fila != null) {
                $presupuesto = $fila['presupuesto'];
                while ($fila != null) {
                    $presupuesto = $presupuesto + $fila['cantidad'];
                    echo "<tr>";
                    echo "<td>" . $fila['codigoMov'] . "</td>";
                    echo "<td>" . $fila['fecha'] . "</td>";
                    echo "<td>" . $fila['concepto'] . "</td>";
                    if ($fila['cantidad'] > 0) {
                        echo "<td style='color:blue;'>" . $fila['cantidad'] . "</td>";
                    } else {
                        echo "<td style='color:red;'>" . $fila['cantidad'] . "</td>";
                    }
                    echo "<td>" . $presupuesto . "</td>";
                    echo "</tr>";
                    $fila = $resultado->fetch();
                }
            }

            }
        } catch (PDOException $e) {
            $error = $e->getCode();
            $mensaje = $e->getMessage();
            echo "Ha ocurrido un error";
        }
        unset($conexion);
    }

    function calcular_saldo_actual($base,$login){
        try {
            $conexion = conectarBD($base);
            $sql = "SELECT codigoMov,cantidad,presupuesto FROM movimientos INNER JOIN usuarios ON loginUsu=login WHERE login='$login'";
            if ($resultado = $conexion->query($sql)) {
                $fila = $resultado->fetch();
            if ($fila != null) {
                $presupuesto = $fila['presupuesto'];
                while ($fila != null) {
                    $presupuesto = $presupuesto + $fila['cantidad'];
                    $fila = $resultado->fetch();
                }
                return $presupuesto;
            }else{
                return 0;
            }

            }
        } catch (PDOException $e) {
            $error = $e->getCode();
            $mensaje = $e->getMessage();
        }
        unset($conexion);
    }

    function mostrar_num_movimientos($base,$login){
        try {
            $conexion=conectarBD($base);
            $sql="SELECT COUNT(codigoMov) FROM movimientos WHERE loginUsu='$login'";
            if($resultado=$conexion->query($sql)){
                $fila=$resultado->fetch();
                while($fila!=null){
                    return $fila['COUNT(codigoMov)'];
                }
            }
        } catch (PDOException $e) {
            $error = $e->getCode();
            $mensaje = $e->getMessage();
            echo "Ha ocurrido un error";
        }
        unset($conexion);
    }

    //----------------------Funciones utilizadas para contabilizar un ingreso o una devolucion------------------------------------------------

    function get_cod_ultimo_mov($base){
        try {
            $conexion = conectarBD($base);
            $sql = "SELECT MAX(codigoMov) FROM movimientos";
            $resultado=$conexion->query($sql);
            if ($resultado) {
                $fila = $resultado->fetch();
                if($fila!=null){
                    $codigo=$fila['MAX(codigoMov)'];
                    $codigo++;
                    return $codigo;
                }
            }else{
                return 0;
            }
        } catch (PDOException $e) {
            $error = $e->getCode();
            $mensaje = $e->getMessage();
        }
        unset($conexion);
    }

    //----------------------Funciones utilizadas para realizar una devolucion------------------------------------------------

    function mostrar_tabla_devoluciones($base,$login){
        try {
            $conexion = conectarBD($base);
            $sql = "SELECT codigoMov,fecha,concepto,cantidad FROM movimientos  WHERE loginUsu='$login'";
            if ($resultado = $conexion->query($sql)) {
                $fila = $resultado->fetch();
                while ($fila != null) {
                    echo "<tr>";
                    echo "<td>" . $fila['fecha'] . "</td>";
                    echo "<td>" . $fila['concepto'] . "</td>";
                    if($fila['cantidad']>0){
                        echo "<td style='color:blue;'>" . $fila['cantidad'] . "</td>";
                    }else{
                        echo "<td style='color:red;'>" . $fila['cantidad'] . "</td>";
                    }
                    echo "<td><a class='boton' href='devolver2.php?codMov=".$fila['codigoMov']."'>Devolver</a></td>";
                    echo "</tr>";
                    $fila = $resultado->fetch();
                }
            }
        } catch (PDOException $e) {
            $error = $e->getCode();
            $mensaje = $e->getMessage();
            echo "Ha ocurrido un error";
        }
        unset($conexion);
    }

?>