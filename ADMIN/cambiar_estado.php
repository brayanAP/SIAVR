<?php 
     if(!isset($_SESSION)) 
    { 
        session_start(); 
    }

    if(isset($_SESSION['user']) and isset($_SESSION['pass']) and isset($_SESSION['cargo'])){
        if($_SESSION['cargo'] != 1){
             session_destroy(); 
        header("Location: ../LOGIN/index.html");
        }
    }else{
        session_destroy(); 
        header("Location: ../LOGIN/index.html");
    }
?>
<?php 

	$id = $_REQUEST['id'];
	$car = $_REQUEST['car'];
	$temp = true;

	if ($car == 1){
		echo "<script>alert('ERROR: No se puede modificar el estado de un admin.');</script>";
		echo "<script>window.location='index.php';</script>";
		$temp = false;
	}

	include("conexion.php");

	function buscar_usuario($id){
		include("conexion.php");

		$res = $conexion->query("SELECT estado FROM usuarios WHERE id = '$id'");

		if($res){
			$row = $res->fetch_row();
			return $row[0];
		}else{
			return false;
		}
	}

	if($temp){
		$estado = buscar_usuario($id);
		$sql = "";

		if ($estado == 'D'){
			$sql = "UPDATE usuarios SET estado = 'N' WHERE id = '$id'";
		}else{
			$sql = "UPDATE usuarios SET estado = 'D' WHERE id = '$id'";
		}

		$respuesta = $conexion->query($sql);

		if($respuesta){
			echo "<script>alert('Estado cambiado con éxito.');</script>";
			echo "<script>window.location='index.php';</script>";
		}else{
			echo "<script>alert('ERROR: No se puedo modificar el estado.');</script>";
			echo "<script>window.location='index.php';</script>";
		}
	}

?>