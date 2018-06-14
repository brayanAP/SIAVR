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
    // Variables con la informacion del alumno
    $idmenu = $_POST['menu'];
    $idplatillos = $_POST['idplatillos'];
    //Se crea la respuesta del servidor
    $respuesta = new stdClass();
    // Se realiza la conexion con la base de datos
    include("conexion.php");
    $conexion->autocommit(FALSE);

    //Se obtiene el id del alumno que se insertó
    #$idmenu = 2;
      // Se elimina la ultima coma de la cadena
    $idplatillos = trim($idplatillos,',');
      // Se dividen los valores de la cadena en un arreglo
    $idplatillos = explode(',', $idplatillos);
      // Se recorre el arreglo de idiomas
    foreach ($idplatillos as $idplatillo) {
 
          $consulta = "INSERT INTO platillos_menu (menus_id, platillos_id) VALUE($idmenu,$idplatillo)";
          // Se ejecuta cada consulta para guardar los idiomas
        if( $conexion->query($consulta) == FALSE ){
                  // Se ejecuta este codigo si alguna consulta no se ejecutó correctamente
          $respuesta->estado = FALSE;
          $conexion->rollback();
          echo json_encode($respuesta);
          die();
        }
    }
    $respuesta->estado = TRUE;
    $conexion->commit();
    echo json_encode($respuesta);

?>