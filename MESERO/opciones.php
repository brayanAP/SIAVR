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
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>SIAVR</title>
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <script src="http://code.jquery.com/jquery-latest.js"></script>
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Patua+One|Source+Sans+Pro" rel="stylesheet">
        <link rel="stylesheet" href="font/flaticon.css">
        <script src="../GENERALES/js/main.js"></script>
        <link rel="stylesheet" href="../GENERALES/css/menu.css">
        <script src="../GENERALES/js/menu.js"></script>
        <link rel="stylesheet" href="../GENERALES/css/estilos.css">
        <link rel="stylesheet" href="css/admin.css">
    </head>
    <body>
        <header class="barra-principal">
            <figure>
                <img src="../GENERALES/img/logo.png" alt="logo_siavr">
            </figure>
            <div>
                <span>
                    <p><script type="text/javascript">dia_semana ();</script></p>
                    <p><script type="text/javascript">fecha ();</script></p>
                </span>
                <p class="hora"><script type="text/javascript">hora();</script></p>
                <a href="cerrar.php" class="boton-principal"><i class="material-icons">supervisor_account</i></a>
            </div>
        </header>
        <script>
                        function eliminar(){
                            var ventana = confirm("¿En realidad, quieres solicitar la cuenta?","");
                            return ventana;
                        }
                        function cancelar(){
                            var ventana = confirm("¿En realidad, quieres cancelar el pedido?","");
                            return ventana;
                        }
                    </script>

        <?php 
            $id = $_REQUEST['id'];
         ?>
        <div id="menuopciones">
            <a href="form_tomar_pedido.php?id=<?php echo $id; ?>">
                <i class="material-icons">restaurant_menu</i>
                <p>Tomar pedido</p>
            </a>
            <a href="verificar_pedido.php?id=<?php echo $id; ?>">
                <i class="material-icons">record_voice_over</i>
                <p>Verificar pedido</p>
            </a>
            <a href="solicitar_cuenta.php?id=<?php echo $id; ?>" onclick="return eliminar();">
                <i class="material-icons">attach_money</i>
                <p>Solicitar la cuenta</p>
            </a>
            <a href="cancelar_pedido.php?id=<?php echo $id; ?>" onclick="return cancelar();">
                <i class="material-icons">cancel</i>
                <p>Cancelar pedido</p>
            </a>
            <a href="index.php">
                <i class="material-icons">reply</i>
                <p>Regresar</p>
            </a>
            
        </div>
    </body>
</html>