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
	$mesa = $_REQUEST['id'];

	include("conexion.php");

	$sql = "UPDATE pedidos SET estado = 'S' WHERE mesas_id = '$mesa'";

		$respuesta = $conexion->query($sql);

		if($respuesta){
			echo "<script>alert('Cuenta solicitada.');</script>";
			echo "<script>window.location='index.php';</script>";
		}else{
			echo "<script>alert('ERROR: No se puedo solicitar la cuenta.');</script>";
			echo "<script>window.location='index.php';</script>";
		}
?>