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

    include("conexion.php");

    $id = $_REQUEST['id'];
    $car = $_REQUEST['car'];
    $temp = true;

    if($car == 1){
        echo "<script>alert('ERROR: No se puede eliminar a un admin.');</script>";
        echo "<script>window.location='index.php';</script>";
        $temp = false;
    }

    if($temp){
        $sql = "DELETE FROM usuarios WHERE id = '$id'";
        $respuesta = $conexion->query($sql);

        if($respuesta){
            echo "<script>alert('Usuario eliminado con éxito.');</script>";
            echo "<script>window.location='index.php';</script>"; 
        }else{
            echo "<script>alert('ERROR: No se puedo eliminar el usuario.');</script>";
            echo "<script>window.location='index.php';</script>";
        }
    }

?>