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
	function buscar_menu($id){
		include("conexion.php");

		$res = $conexion->query("SELECT estado FROM menus WHERE id = '$id'");

		if($res){
			$row = $res->fetch_row();
			return $row[0];
		}else{
			return false;
		}
	}

	function cambiar_estado_menu($id){
		include("conexion.php");

		$estado = buscar_menu($id);
		$sql = "";

		if ($estado == 'D'){
			$sql = "UPDATE menus SET estado = 'N' WHERE id = '$id'";
		}else{
			$sql = "UPDATE menus SET estado = 'D' WHERE id = '$id'";
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

	function buscar_tipo($id){
		include("conexion.php");

		$res = $conexion->query("SELECT estado FROM tipos WHERE id = '$id'");

		if($res){
			$row = $res->fetch_row();
			return $row[0];
		}else{
			return false;
		}
	}

	function cambiar_estado_tipo($id){
		include("conexion.php");

		$estado = buscar_tipo($id);
		$sql = "";

		if ($estado == 'D'){
			$sql = "UPDATE tipos SET estado = 'N' WHERE id = '$id'";
		}else{
			$sql = "UPDATE tipos SET estado = 'D' WHERE id = '$id'";
		}

		$respuesta = $conexion->query($sql);

		if($respuesta){
			echo "<script>alert('Estado cambiado con éxito.');</script>";
			echo "<script>window.location='tipos.php';</script>";
		}else{
			echo "<script>alert('ERROR: No se puedo modificar el estado.');</script>";
			echo "<script>window.location='tipos.php';</script>";
		}
	}

	function buscar_platillo($id){
		include("conexion.php");

		$res = $conexion->query("SELECT estado FROM platillos WHERE id = '$id'");

		if($res){
			$row = $res->fetch_row();
			return $row[0];
		}else{
			return false;
		}
	}

	function cambiar_estado_platillos($id){
		include("conexion.php");

		$estado = buscar_platillo($id);
		$sql = "";

		if ($estado == 'D'){
			$sql = "UPDATE platillos SET estado = 'N' WHERE id = '$id'";
		}else{
			$sql = "UPDATE platillos SET estado = 'D' WHERE id = '$id'";
		}

		$respuesta = $conexion->query($sql);

		if($respuesta){
			echo "<script>alert('Estado cambiado con éxito.');</script>";
			echo "<script>window.location='platillos.php';</script>";
		}else{
			echo "<script>alert('ERROR: No se puedo modificar el estado.');</script>";
			echo "<script>window.location='platillos.php';</script>";
		}
	}

	$id = $_REQUEST['id'];
	$op = $_REQUEST['op'];

	switch ($op) {
		case 1:
			cambiar_estado_menu($id);
			break;
		case 2:
			cambiar_estado_tipo($id);
			break;
		case 3:
			cambiar_estado_platillos($id);
			break;
		
		default:
			# invalida
			break;
	}
?>