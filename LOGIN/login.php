<?php 
function encriptar($cadena,$key){
        $encrypted = base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($key), $cadena, MCRYPT_MODE_CBC, md5(md5($key))));
        return $encrypted; //Devuelve el string encriptado
}


function Sesion($user,$pass){
	include("conexion.php");
	$res = $conexion->query("SELECT * FROM usuarios WHERE (username='$user' AND password='$pass') AND estado='D'");
		session_start();
        if($comprobar = mysqli_fetch_array($res)){
	        $_SESSION['user'] = $user;
			$_SESSION['pass'] = $pass;
			$cargo = buscar_cargo($user);
			$_SESSION['cargo'] = $cargo;
			switch ($cargo) {
				case 1:
					header("Location: ../ADMIN/index.php");
					break;
				case 2:
					header("Location: ../CHEF/index.php");
					break;
				case 3:
					header("Location: ../CAJERO/index.php");
					break;
				case 4:
					header("Location: ../MESERO/index.php");
					break;
				
			}
        }else{
				header("Location: ../LOGIN/index.html");
		}
}


function buscar_cargo($user){
        include("conexion.php");

        $res = $conexion->query("SELECT c.id FROM usuarios u
				INNER JOIN cargos c ON c.id = u.cargos_id
				WHERE u.username = '$user'");

        if($res){
            $row = $res->fetch_row();
            return $row[0];
        }else{
            return false;
        }
}

$user = $_POST['user'];
$pass = $_POST['pass'];

//$pass = encriptar($pass,$user);
Sesion($user,$pass);
?>