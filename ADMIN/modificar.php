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

    function encriptar($cadena,$key){
        $encrypted = base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($key), $cadena, MCRYPT_MODE_CBC, md5(md5($key))));
        return $encrypted; //Devuelve el string encriptado
    }


    $id = $_REQUEST['id'];
    $car = $_REQUEST['car'];
    $nom = $_REQUEST['nom'];
    $temp = true;

    if ($car == 1){
        echo "<script>alert('ERROR: No se puede modificar un admin.');</script>";
        echo "<script>window.location='index.php';</script>";
        $temp = false;
    }

    $nombre = $_POST['nombre'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $password_co = $_POST['password_co'];
    $estado = $_POST['estado'];

    $nombre = strtoupper($nombre);

    include("conexion.php");

        /*-------------------------- V A L I D A R -------------------------------------------------------------------*/

        if($nom != $nombre){
            $res = $conexion->query("SELECT * FROM usuarios WHERE nombreC = '$nombre'");

            if($comprobar = mysqli_fetch_array($res)){
                echo "<script>alert('ERROR: Ya existe un usuario registrado con ese nombre.');</script>";
                echo "<script>window.history.back();</script>";
                $temp = false;
            }//vallidar nombre
        }


        if (strlen($password) > "20") {
            echo "<script>alert('ERROR: La contraseña no puede tener más de 20 caracteres.');</script>";
            echo "<script>window.history.back();</script>";
            $temp = false;
        }//validar contraseña

        if($password != $password_co){
            echo "<script>alert('ERROR: Las contraseñas no coinciden.');</script>";
            echo "<script>window.history.back();</script>";
            $temp = false;
        }//validar contraseña

        switch ($estado) {
            case 'default':
                echo "<script>alert('ERROR: Seleccione un estado.');</script>";
                echo "<script>window.history.back();</script>";
                $temp = false;
                break;
        
            case 'activo':
                $estado = "D";
                break;

            case 'inactivo':
                $estado = "N";
                break;
       }


    if($temp){
       // $password = encriptar($password,$username);

        $sql = "UPDATE usuarios SET nombreC = '$nombre',
                            password = '$password',
                            estado = '$estado' 
                            WHERE id = '$id'";

        $res = $conexion->query($sql);

        if($res){
            echo "<script>alert('Usuario modificado con éxito.');</script>";
            echo "<script>window.location='index.php';</script>";
        }else{
            echo "<script>alert('ERROR: Ocurrió un error al modificar el usuario.');</script>";
            echo "<script>window.location='index.php';</script>";
       }
    }

?>