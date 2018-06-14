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

    function contar_platillos($pedido){
        include("conexion.php");

        $res = $conexion->query("SELECT count(*) FROM toma_pedido WHERE pedidos_id = '$pedido'");

        if($res){
            $row = $res->fetch_row();
            return $row[0];
        }else{
            return false;
        }
    }//buscar cantidad

    function eliminar_toma($mesa,$pedido){
        include("conexion.php");

        $cant = contar_platillos($pedido);
        if($cant == false){
            echo "<script>alert('ERROR: Ocurrió un error al contar los platillos.');</script>";
            echo "<script>window.history.back();</script>";
            return false;
        }

        $dx = 0;
        while ( $dx != $cant) {
            $sql = "DELETE FROM toma_pedido WHERE pedidos_id = '$pedido'";
            $respuesta = $conexion->query($sql);

            if($respuesta){
                $dx = $dx + 1;
            }else{
                return false;
            }
        }
        echo "<script>alert('Toma eliminada con éxito.');</script>";
        return true;

    }

    function cancelar_pedido($mesa){
        include("conexion.php");
        $sql = "DELETE FROM pedidos WHERE mesas_id = '$mesa'";

            $respuesta = $conexion->query($sql);

            if($respuesta){
                echo "<script>alert('Pedido eliminado con éxito.');</script>";
                return true;

            }else{
                echo "<script>alert('ERROR: No se puedo eliminar el pedido.');</script>";
                return false;
            }

    }

    function cambiar_estado_mesa($mesa){
        include("conexion.php");

        $sql = "UPDATE mesas SET estado = 'D' WHERE id = '$mesa'";

        $respuesta = $conexion->query($sql);

        if($respuesta){
            echo "<script>alert('Estado de mesa cambiado con éxito.');</script>";
            return true;
        }else{
            echo "<script>alert('ERROR: No se puedo modificar el estado de la mesa.');</script>";
            return false;
        }
    }



    $mesa = $_REQUEST['id'];

    $pedido = buscar_pedido($mesa);

    if($pedido){
        $el = eliminar_toma($mesa,$pedido);
        if($el){
         $ca = cancelar_pedido($mesa);
         if($ca){
            $me = cambiar_estado_mesa($mesa);
            if($me){
                echo "<script>window.location='index.php';</script>";
            }
         }
        }
    }else{
        echo "<script>alert('ERROR: Ocurrió un error al cancelar el pedido.');</script>";
        echo "<script>window.location='index.php';</script>";
    }

?>