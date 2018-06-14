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
    
    function modificar_menu($id,$nombre){
        include("conexion.php");

        if (strlen($nombre) > "45") {
            echo "<script>alert('ERROR: El nombre no puede tener más de 45 caracteres.');</script>";
            echo "<script>window.history.back();</script>";
            return false;
        }//validar nombre

        $res = $conexion->query("SELECT * FROM menus WHERE nombre = '$nombre'");

        if($comprobar = mysqli_fetch_array($res)){
            echo "<script>alert('ERROR: Ya existe un menú con ese nombre.');</script>";
            echo "<script>window.history.back();</script>";
            return false;
        }//vallidar nombre

        $sql = "UPDATE menus SET nombre = '$nombre',fecha_actualizacion = NOW() WHERE id = '$id'";

        $res = $conexion->query($sql);

        if($res){
            echo "<script>alert('Menú modificado con éxito.');</script>";
            echo "<script>window.location='index.php';</script>";
        }else{
            echo "<script>alert('ERROR: Ocurrió un error al modificar el menú.');</script>";
            echo "<script>window.location='index.php';</script>";
       }
    }

    function modificar_tipo($id,$nombre){
        include("conexion.php");

        if (strlen($nombre) > "45") {
            echo "<script>alert('ERROR: El nombre no puede tener más de 45 caracteres.');</script>";
            echo "<script>window.history.back();</script>";
            return false;
        }//validar nombre

        $res = $conexion->query("SELECT * FROM tipos WHERE tipo = '$nombre'");

        if($comprobar = mysqli_fetch_array($res)){
            echo "<script>alert('ERROR: Ya existe un tipo con ese nombre.');</script>";
            echo "<script>window.history.back();</script>";
            return false;
        }//vallidar nombre

        $sql = "UPDATE tipos SET tipo = '$nombre' WHERE id = '$id'";

        $res = $conexion->query($sql);

        if($res){
            echo "<script>alert('Tipo modificado con éxito.');</script>";
            echo "<script>window.location='tipos.php';</script>";
        }else{
            echo "<script>alert('ERROR: Ocurrió un error al modificar el tipo.');</script>";
            echo "<script>window.location='tipos.php';</script>";
       }
    }


    function buscar_tipo($tipo){
        include("conexion.php");

        $res = $conexion->query("SELECT id FROM tipos WHERE tipo = '$tipo'");

        if($res){
            $row = $res->fetch_row();
            return $row[0];
        }else{
            return false;
        }
    }

    $nombre = $_POST['nombre'];
    @$descripcion = $_POST['descripcion'];
    @$precio = $_POST['precio'];
    @$tipo = $_POST['tipo'];

    $nombre = strtoupper($nombre);

    $id = $_REQUEST['id'];
    $op = $_REQUEST['op'];
    $nom = $_REQUEST['nom'];

    switch ($op) {
        case 1:
            modificar_menu($id,$nombre);
            break;
        case 2:
            modificar_tipo($id,$nombre);
            break;
        case 3:
            include("conexion.php");

                /*-------------------------- V A L I D A R -------------------------------------------------------------------*/
                if (strlen($nombre) > "45") {
                    echo "<script>alert('ERROR: El nombre no puede tener más de 45 caracteres.');</script>";
                    echo "<script>window.history.back();</script>";
                    return false;
                }//validar nombre

                 $permitidos = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789() "; 
                   for ($i=0; $i<strlen($nombre); $i++){ 
                      if (strpos($permitidos, substr($nombre,$i,1))===false){ 
                         echo "<script>alert('ERROR: Nombre invalido.');</script>";
                        echo "<script>window.history.back();</script>";
                         return false; 
                      } 
                   } 

                if (strlen($descripcion) > "500") {
                    echo "<script>alert('ERROR: La descripción no puede tener más de 500 caracteres.');</script>";
                    echo "<script>window.history.back();</script>";
                    return false;
                }//validar descripcion

                $permitidos = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789()-. "; 
               for ($i=0; $i<strlen($descripcion); $i++){ 
                  if (strpos($permitidos, substr($descripcion,$i,1))===false){ 
                     echo "<script>alert('ERROR: Descripción invalida.');</script>";
                    echo "<script>window.history.back();</script>";
                     return false; 
                  } 
               }

                if ($nombre != $nom){
                    $res = $conexion->query("SELECT * FROM platillos WHERE nombre = '$nombre'");

                    if($comprobar = mysqli_fetch_array($res)){
                        echo "<script>alert('ERROR: Ya existe un tipo con ese nombre.');</script>";
                        echo "<script>window.history.back();</script>";
                        return false;
                    }//vallidar nombre
                }//validar nombre

                if ($precio <= 0 OR $precio >= 3000) {
                    echo "<script>alert('ERROR: Precio invalido.');</script>";
                    echo "<script>window.history.back();</script>";
                    return false;
                }//validar precio

                $permitidos = "0123456789"; 
               for ($i=0; $i<strlen($precio); $i++){ 
                  if (strpos($permitidos, substr($precio,$i,1))===false){ 
                     echo "<script>alert('ERROR: Precio invalido.');</script>";
                        echo "<script>window.history.back();</script>";
                     return false; 
                  } 
               } 

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

               /*-------------------------- I N S E R T A R -------------------------------------------------------------------*/
               $tipo = buscar_tipo($tipo);

                $sql = "UPDATE platillos SET nombre = '$nombre',
                                            descripcion = '$descripcion',
                                            precio = '$precio',
                                            tipos_id = '$tipo' WHERE id = '$id'";

                $res = $conexion->query($sql);

                if($res){
                    echo "<script>alert('Platillo modificado con éxito.');</script>";
                    echo "<script>window.location='platillos.php';</script>";
                }else{
                    echo "<script>alert('ERROR: Ocurrió un error al modificar el platillo.');</script>";
                    echo "<script>window.location='platillos.php';</script>";
               }
            break;
        
        default:
            # invalida
            break;
    }
?>