<?php 
     if(!isset($_SESSION)) 
    { 
        session_start(); 
    }

    if(isset($_SESSION['user']) and isset($_SESSION['pass']) and isset($_SESSION['cargo'])){
        if($_SESSION['cargo'] != 2){
             session_destroy(); 
        header("Location: ../LOGIN/index.html");
        }
    }else{
        session_destroy(); 
        header("Location: ../LOGIN/index.html");
    }
?>
<?php  
	function listo($pedido){
		include("conexion.php");

		$sql = "UPDATE pedidos SET estado = 'L' WHERE id = '$pedido'";

		$respuesta = $conexion->query($sql);

		if($respuesta){
			echo "<script>alert('Estado cambiado con éxito.');</script>";
			echo "<script>window.location='pedidos.php';</script>";
			return true;
		}else{
			echo "<script>alert('ERROR: No se puedo modificar el estado.');</script>";
			echo "<script>window.location='pedidos.php';</script>";
			return false;
		}
	}

	function espera($pedido){
		include("conexion.php");

		$sql = "UPDATE pedidos SET estado = 'E' WHERE id = '$pedido'";

		$respuesta = $conexion->query($sql);

		if($respuesta){
			echo "<script>alert('Estado cambiado con éxito.');</script>";
			echo "<script>window.location='pedidos.php';</script>";
			return true;
		}else{
			echo "<script>alert('ERROR: No se puedo modificar el estado.');</script>";
			echo "<script>window.location='pedidos.php';</script>";
			return false;
		}
	}

	function preparando($pedido){
		include("conexion.php");

		$sql = "UPDATE pedidos SET estado = 'P' WHERE id = '$pedido'";

		$respuesta = $conexion->query($sql);

		if($respuesta){
			echo "<script>alert('Estado cambiado con éxito.');</script>";
			echo "<script>window.location='pedidos.php';</script>";
			return true;
		}else{
			echo "<script>alert('ERROR: No se puedo modificar el estado.');</script>";
			echo "<script>window.location='pedidos.php';</script>";
			return false;
		}
	}

	$pedido = $_REQUEST['pedido'];
	$op = $_REQUEST['op'];

	switch ($op) {
		case 1:
			preparando($pedido);
			break;
		case 2:
			espera($pedido);
			break;
		case 3:
			listo($pedido);
			break;
	}
?>