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
  function nuevo_menu($nombre,$estado){
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

    $res = $conexion->query("SELECT * FROM menus WHERE nombre = '$nombre'");

        if($comprobar = mysqli_fetch_array($res)){
            echo "<script>alert('ERROR: Ya existe un menú con ese nombre.');</script>";
            echo "<script>window.history.back();</script>";
            return false;
        }//vallidar nombre

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
       $sql = "INSERT INTO menus(nombre,fecha_creacion,fecha_actualizacion,estado)  VALUES ('$nombre',NOW(),NOW(),'$estado')";
        $res = $conexion->query($sql);

        if($res){
            echo "<script>alert('Menú guardado con éxito.');</script>";
            echo "<script>window.location='index.php';</script>";
            return true;
        }else{
            echo "<script>alert('ERROR: Ocurrió un error al guardar el menú.');</script>";
            echo "<script>window.location='index.php';</script>";
            return false;
       }
  }//Nuevo menu

    function nuevo_tipo($nombre,$estado){
        include("conexion.php");

        /*-------------------------- V A L I D A R -------------------------------------------------------------------*/
        if (strlen($nombre) > "45") {
            echo "<script>alert('ERROR: El nombre no puede tener más de 45 caracteres.');</script>";
            echo "<script>window.history.back();</script>";
            return false;
        }//validar nombre

        $permitidos = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ "; 
           for ($i=0; $i<strlen($nombre); $i++){ 
              if (strpos($permitidos, substr($nombre,$i,1))===false){ 
                 echo "<script>alert('ERROR: Nombre invalido.');</script>";
                echo "<script>window.history.back();</script>";
                 return false; 
              } 
           }

        $res = $conexion->query("SELECT * FROM tipos WHERE tipo = '$nombre'");

        if($comprobar = mysqli_fetch_array($res)){
            echo "<script>alert('ERROR: Ya existe un tipo con ese nombre.');</script>";
            echo "<script>window.history.back();</script>";
            return false;
        }//vallidar nombre

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
       $sql = "INSERT INTO tipos(tipo,estado)  VALUES ('$nombre','$estado')";
        $res = $conexion->query($sql);

        if($res){
            echo "<script>var notification = new Notification('SIAVR dice:', {body: 'Tipo guardado con éxito.'});</script>";
            echo "<script>window.location='nuevo_tipo.html';</script>";
            return true;
        }else{
            echo "<script>alert('ERROR: Ocurrió un error al guardar el tipo.');</script>";
            echo "<script>window.location='tipos.php';</script>";
            return false;
       }
    }//Nuevo tipo

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

    function nuevo_platillo($nombre,$descripcion,$precio,$estado,$tipo){
        include("conexion.php");

        /*-------------------------- V A L I D A R -------------------------------------------------------------------*/
        if (strlen($nombre) > "45") {
            echo "<script>alert('ERROR: El nombre no puede tener más de 45 caracteres.');</script>";
            echo "<script>window.history.back();</script>";
            return false;
        }//validar nombre
/*
        $permitidos = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789(). "; 
           for ($i=0; $i<strlen($nombre); $i++){ 
              if (strpos($permitidos, substr($nombre,$i,1))===false){ 
                 echo "<script>alert('ERROR: Nombre invalido.');</script>";
                echo "<script>window.history.back();</script>";
                 return false; 
              } 
           } 
*/
        if (strlen($descripcion) > "500") {
            echo "<script>alert('ERROR: La descripción no puede tener más de 500 caracteres.');</script>";
            echo "<script>window.history.back();</script>";
            return false;
        }//validar descripcion
/*
        $permitidos = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789()-., "; 
           for ($i=0; $i<strlen($descripcion); $i++){ 
              if (strpos($permitidos, substr($descripcion,$i,1))===false){ 
                 echo "<script>alert('ERROR: Descripción invalida.');</script>";
                echo "<script>window.history.back();</script>";
                 return false; 
              } 
           }
*/
        $res = $conexion->query("SELECT * FROM platillos WHERE nombre = '$nombre'");

        if($comprobar = mysqli_fetch_array($res)){
            echo "<script>alert('ERROR: Ya existe un tipo con ese nombre.');</script>";
            echo "<script>window.history.back();</script>";
            return false;
        }//vallidar nombre

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
       $sql = "INSERT INTO platillos(nombre,descripcion,precio,estado,tipos_id)  VALUES ('$nombre','$descripcion','$precio','$estado','$tipo')";
        $res = $conexion->query($sql);

        if($res){
            echo "<script>var notification = new Notification('SIAVR dice:', {body: 'Platillo guardado con éxito.'});</script>";
            echo "<script>window.location='nuevo_platillo.php';</script>";
            return true;
        }else{
            echo "<script>alert('ERROR: Ocurrió un error al guardar el platillo.');</script>";
            echo "<script>window.location='nuevo_platillo.php';</script>";
            return false;
       }
    }//Nuevo paltillo

  $nombre = $_POST['nombre'];
    @$descripcion = $_POST['descripcion'];
    @$precio = $_POST['precio'];
    $estado = $_POST['estado'];
    @$tipo = $_POST['tipo'];

    $nombre = strtoupper($nombre);

  $op = $_REQUEST['op'];

  switch ($op) {
    case 1:
      nuevo_menu($nombre,$estado);
      break;
    case 2:
      nuevo_tipo($nombre,$estado);
      break;
    case 3:
      nuevo_platillo($nombre,$descripcion,$precio,$estado,$tipo);
      break;
    
    default:
      # invalida
      break;
  }
?>