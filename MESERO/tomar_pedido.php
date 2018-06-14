<?php 
     if(!isset($_SESSION)) 
    { 
        session_start(); 
    }

    if(isset($_SESSION['user']) and isset($_SESSION['pass']) and isset($_SESSION['cargo'])){
        if($_SESSION['cargo'] != 4){
             session_destroy(); 
        header("Location: ../LOGIN/index.html");
        }
    }else{
        session_destroy(); 
        header("Location: ../LOGIN/index.html");
    }
?>
<?php 
    function cambiar_estado_mesa($mesa){
        include("conexion.php");

        $sql = "UPDATE mesas SET estado = 'N' WHERE id = '$mesa'";

        $respuesta = $conexion->query($sql);

        if($respuesta){
            return true;
        }else{
            return false;
        }
    }//cambiar estado mesa

    function buscar_mesa($mesa){
        include("conexion.php");

        $res = $conexion->query("SELECT estado FROM mesas WHERE id = '$mesa'");

        if($res){
            $row = $res->fetch_row();
            return $row[0];
        }else{
            return false;
        }
    }//buscar mesa

    function buscar_usuario($user){
        include("conexion.php");

        $res = $conexion->query("SELECT id FROM usuarios WHERE username = '$user'");

        if($res){
            $row = $res->fetch_row();
            return $row[0];
        }else{
            return false;
        }
    }//buscar mesa

    function crear_pedido($mesa){
        $temp = buscar_mesa($mesa);

        if($temp == "D"){
            $op = cambiar_estado_mesa($mesa);
            if($op){
                $userr = buscar_usuario($_SESSION['user']);
                include("conexion.php");
                $sql = "INSERT INTO pedidos(total,estado,fecha_hora_inicio,fecha_hora_final,usuarios_id,mesas_id)  VALUES (0,'E',NOW(),NOW(),'$userr','$mesa')";
                $res = $conexion->query($sql);

                if($res){
                   // echo "<script>alert('Pedido guardado con éxito.');</script>";
                    return true;
                }else{
                    echo "<script>alert('ERROR: Ocurrió un error al guardar el pedido.');</script>";
                    echo "<script>window.location='index.php';</script>";
                    return false;
               }
           }else{
                echo "<script>alert('ERROR: Ocurrió un error al guardar el estado de la mesa.');</script>";
                echo "<script>window.location='index.php';</script>";
                return false;
           }
        }else{
            return false;
        }
    }//crear pedido

    function buscar_pedido($mesa){
        include("conexion.php");

        $res = $conexion->query("SELECT p.id FROM pedidos p INNER JOIN mesas m ON m.id = '$mesa' AND m.estado = 'N' WHERE mesas_id = '$mesa';");

        if($res){
            $row = $res->fetch_row();
            return $row[0];
        }else{
            return false;
        }
    }//buscar pedido

    function buscar_cantidad($pedido,$platillo){
        include("conexion.php");

        $res = $conexion->query("SELECT numero FROM toma_pedido WHERE pedidos_id = '$pedido' AND platillos_id = '$platillo'");

        if($res){
            $row = $res->fetch_row();
            return $row[0];
        }else{
            return false;
        }
    }//buscar cantidad

    function insertar($pedido,$platillo,$mesa){
        include("conexion.php");
        $sql = "INSERT INTO toma_pedido(pedidos_id,platillos_id,numero)  VALUES ('$pedido','$platillo',1)";
        $res = $conexion->query($sql);

        if($res){
            echo "<script>var notification = new Notification('SIAVR dice:', {body: 'Platillo guardado con éxito.'});setTimeout(n.close.bind(n), 3000) ;</script>";
            echo "<script>window.history.back();</script>";
            return true;
        }else{
            echo "<script>alert('ERROR: Ocurrió un error al guardar el platillo.');</script>";
            echo "<script>window.history.back();</script>";
            return false;
       }
    }//insertar platillo

    function editar($pedido,$platillo,$cantidad,$mesa){
        include("conexion.php");

        $sql = "UPDATE toma_pedido SET numero = '$cantidad' WHERE pedidos_id = '$pedido' AND platillos_id = '$platillo'";

        $respuesta = $conexion->query($sql);

        if($respuesta){
            echo "<script>var notification = new Notification('SIAVR dice:', {body: 'Cantidad editada con éxito.'});setTimeout(n.close.bind(n), 3000) ;</script>";
            echo "<script>window.history.back();</script>";
            return true;
        }else{
            echo "<script>alert('ERROR: Ocurrió un error al editar la cantidad.');</script>";
            echo "<script>window.history.back();</script>";
            return false;
       }
    }//editar platillo

    function tomar_pedido($mesa,$platillo){
        crear_pedido($mesa);

        $pedido = buscar_pedido($mesa);
        if($pedido == false){
            return false;
        }

        $insset = true;
        $cantidad = 0;

        include("conexion.php");

        $res = $conexion->query("SELECT * FROM toma_pedido WHERE pedidos_id = '$pedido' AND platillos_id = '$platillo'");

        if($comprobar = mysqli_fetch_array($res)){
            $insset = false;//ya existe un platillo
            $cantidad = buscar_cantidad($pedido,$platillo);
            $cantidad = $cantidad + 1;
        }//vallidar si ya exite platillo en dicho pedido

        if($insset){
            insertar($pedido,$platillo,$mesa);
        }else{
            editar($pedido,$platillo,$cantidad,$mesa);
        }
    }//tomar pedido


    $platillo = $_REQUEST['platillo'];
    $mesa = $_REQUEST['mesa'];

    tomar_pedido($mesa,$platillo);

?>