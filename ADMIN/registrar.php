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

    function nuevo_usuario($nombre,$username,$password,$password_co,$cargo,$estado){
        include("conexion.php");

        /*-------------------------- V A L I D A R -------------------------------------------------------------------*/
        if (strlen($correo) > "80") {
            echo "<script>alert('ERROR: El nombre no puede tener más de 80 caracteres.');</script>";
            echo "<script>window.history.back();</script>";
            return false;
        }//validar nombre

        $res = $conexion->query("SELECT * FROM usuarios WHERE nombreC = '$nombre'");

        if($comprobar = mysqli_fetch_array($res)){
            echo "<script>alert('ERROR: Ya existe un usuario registrado con ese nombre.');</script>";
            echo "<script>window.history.back();</script>";
            return false;
        }//vallidar nombre

        if (strlen($username) > "8") {
            echo "<script>alert('ERROR: El username no puede tener más de 8 caracteres.');</script>";
            echo "<script>window.history.back();</script>";
            return false;
        }//validar username

        $res = $conexion->query("SELECT * FROM usuarios WHERE username = '$username'");

        if($comprobar = mysqli_fetch_array($res)){

            echo "<script>alert('ERROR: Ya existe un usuario registrado con ese username.');</script>";
            echo "<script>window.history.back();</script>";
            return false;
        }//vallidar username

        if (strlen($password) > "20") {
            echo "<script>alert('ERROR: La contraseña no puede tener más de 20 caracteres.');</script>";
            echo "<script>window.history.back();</script>";
            return false;
        }//validar contraseña

        if($password != $password_co){
            echo "<script>alert('ERROR: Las contraseñas no coinciden.');</script>";
            echo "<script>window.history.back();</script>";
            return false;
        }//validar contraseña

        switch ($estado) {
            case 'default':
                echo "<script>alert('ERROR: Seleccione un estado.');</script>";
                echo "<script>window.history.back();</script>";
                return false;
                break;
        
            case 'activo':
                $estado = "D";
                break;

            case 'inactivo':
                $estado = "N";
                break;
       }

        switch ($cargo) {
            case 'default':
                echo "<script>alert('ERROR: Seleccione un cargo.');</script>";
                echo "<script>window.history.back();</script>";
                return false;
                break;
        
            case 'admin':
                echo "<script>alert('ERROR: SIAVR no soporta más de un administrador.');</script>";
                echo "<script>window.history.back();</script>";
                return false;
                break;

            case 'chef':
                $cargo = 2;
                break;

            case 'cajero':
                $cargo = 3;
                break;

            case 'mesero':
                $cargo = 4;
                break;
       }

        /*-------------------------- I N S E R T A R -------------------------------------------------------------------*/
       // $password = encriptar($password,$username);

        $sql = "INSERT INTO usuarios(nombreC,username,password,estado,cargos_id)  VALUES ('$nombre','$username','$password','$estado','$cargo')";
        $res = $conexion->query($sql);

        if($res){
            
            echo "<script>alert('Usuario guardado con éxito.');</script>";
            echo "<script>window.location='index.php';</script>";
            return true;
        }else{
            echo "<script>alert('ERROR: Ocurrió un error al guardar el usuario.');</script>";
            echo "<script>window.location='index.php';</script>";
            return false;
       }
    }

    $nombre = $_POST['nombre'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $password_co = $_POST['password_co'];
    $cargo = $_POST['cargo'];
    $estado = $_POST['estado'];

    $nombre = strtoupper($nombre);
    nuevo_usuario($nombre,$username,$password,$password_co,$cargo,$estado);

?>