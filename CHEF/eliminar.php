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
	function eliminar_tipo($id){
		include("conexion.php");

		$res = $conexion->query("SELECT * FROM platillos WHERE tipos_id = '$id'");

        if($comprobar = mysqli_fetch_array($res)){
            echo "<script>alert('ERROR: Mientras exista un platillo que pertenezca a dicho tipo, no puede ser eliminado el tipo.');</script>";
            echo "<script>window.location='tipos.php';</script>"; 
            return false;
        }//vallidar nombre

	    $sql = "DELETE FROM tipos WHERE id = '$id'";
	    $respuesta = $conexion->query($sql);

	    if($respuesta){
	        echo "<script>alert('Tipo eliminado con éxito.');</script>";
	        echo "<script>window.location='tipos.php';</script>"; 
	    }else{
	        echo "<script>alert('ERROR: No se puedo eliminar el tipo.');</script>";
	        echo "<script>window.location='tipos.php';</script>";
	    }
	}

	function eliminar_menu($id){
		include("conexion.php");

		$res = $conexion->query("SELECT * FROM platillos_menu WHERE menus_id = '$id'");

        if($comprobar = mysqli_fetch_array($res)){
            echo "<script>alert('ERROR: Mientras exista un platillo que pertenezca a dicho menú, no puede ser eliminado el menú.');</script>";
            echo "<script>window.location='index.php';</script>"; 
            return false;
        }//vallidar nombre

	    $sql = "DELETE FROM menus WHERE id = '$id'";
	    $respuesta = $conexion->query($sql);

	    if($respuesta){
	        echo "<script>alert('Menú eliminado con éxito.');</script>";
	        echo "<script>window.location='index.php';</script>"; 
	    }else{
	        echo "<script>alert('ERROR: No se puedo eliminar el menú.');</script>";
	        echo "<script>window.location='index.php';</script>";
	    }
	}

	function eliminar_platillo($id){
		include("conexion.php");

		$res = $conexion->query("SELECT * FROM platillos_menu WHERE platillos_id = '$id'");

        if($comprobar = mysqli_fetch_array($res)){
            echo "<script>alert('ERROR: Mientras exista en un menú dicho platillo, no se puede eliminar el platillo.');</script>";
            echo "<script>window.location='platillos.php';</script>"; 
            return false;
        }//vallidar nombre

	    $sql = "DELETE FROM platillos WHERE id = '$id'";
	    $respuesta = $conexion->query($sql);

	    if($respuesta){
	        echo "<script>alert('Platillo eliminado con éxito.');</script>";
	        echo "<script>window.location='platillos.php';</script>"; 
	    }else{
	        echo "<script>alert('ERROR: No se puedo eliminar el platillo.');</script>";
	        echo "<script>window.location='platillos.php';</script>";
	    }
	}

	function eliminar_menu_platillo($id,$men){
		include("conexion.php");

	    $sql = "DELETE FROM platillos_menu WHERE platillos_id = '$id'";
	    $respuesta = $conexion->query($sql);

	    if($respuesta){
	    	echo "<script>var notification = new Notification('SIAVR dice:', {body: 'Platillo guardado con éxito.'});</script>";
	        echo "<script>window.history.back();</script>";
	    }else{
	        echo "<script>alert('ERROR: No se puedo eliminar el platillo.');</script>";
	        echo "<script>window.location.href='index.php';</script>";
	    }
	}

	$id = $_REQUEST['id'];
	$op = $_REQUEST['op'];
	$men = $_REQUEST['men'];

	switch ($op) {
		case 1:
			eliminar_menu($id);
			break;
		case 2:
			eliminar_platillo($id);
			break;
		case 3:
			eliminar_tipo($id);
			break;
		case 4:
			eliminar_menu_platillo($id,$men);
			break;
		
		default:
			# invalida
			break;
	}
?>