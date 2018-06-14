<?php 
     if(!isset($_SESSION)) 
    { 
        session_start(); 
    }

    if(isset($_SESSION['user']) and isset($_SESSION['pass']) and isset($_SESSION['cargo'])){
        if($_SESSION['cargo'] != 3){
             session_destroy(); 
        header("Location: ../LOGIN/index.html");
        }
    }else{
        session_destroy(); 
        header("Location: ../LOGIN/index.html");
    }
?>
<?php 
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

	function eliminar_toma($mesa,$pedido,$platillo){
		include("conexion.php");

		$cantidad = buscar_cantidad($pedido,$platillo);

		if($cantidad != 1){
			$menos = $cantidad - 1;
			$sql = "UPDATE toma_pedido SET numero = $menos WHERE pedidos_id = '$pedido' AND platillos_id = '$platillo'";
		}else{
			$sql = "DELETE FROM toma_pedido WHERE pedidos_id = '$pedido' AND platillos_id = '$platillo'";
		}

	    $respuesta = $conexion->query($sql);

	    if($respuesta){
	        echo "<script>alert('Platillo quitado con éxito.');</script>";
	        echo "<script>window.location='verificar_pedido.php?id=".$mesa."';</script>";
	    }else{
	        echo "<script>alert('ERROR: No se puedo quitar el platillo.');</script>";
	        echo "<script>window.location='verificar_pedido.php?id=".$mesa."';</script>";
	    }
	}

	$mesa = $_REQUEST['mesa'];
	$pedido = $_REQUEST['pedido'];
	$platillo = $_REQUEST['platillo'];

	eliminar_toma($mesa,$pedido,$platillo);

 ?>