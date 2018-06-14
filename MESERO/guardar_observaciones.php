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
	$pedido = $_REQUEST['pedido'];
    $platillo = $_REQUEST['platillo'];
    $observacion = $_POST['observacion'];

    $sql = "UPDATE toma_pedido  SET descripcion = '$observacion' WHERE pedidos_id = '$pedido' AND platillos_id = '$platillo'";
    	include("conexion.php");
    	
        $res = $conexion->query($sql);

        if($res){
            echo "<script>alert('Observación agregada con éxito.');</script>";
            echo "<script>window.location='observaciones2.php?pedido=".$pedido."';</script>";
        }else{
            echo "<script>alert('ERROR: Ocurrió un error al agregada la observación.');</script>";
            echo "<script>window.location='tipos.php';</script>";
       }
?>