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

        <section class="contenido">
            <div>
                <header>
                    <div class="menu_bar" style="background: #546e7a;">
                        <a href="#" class="bt-menu"><span class="material-icons">dehaze</span>Menu</a>
                    </div>
                    <nav>
                        <ul>
                            <li class="submenu">
                                <a href="index.php" style="font-size: 1.4em;"><span class="flaticon-chef-1"></span>Menú</a>
                            </li>
                            <li class="submenu">
                                <a href="seleccion.php" style="font-size: 1.4em;"><span class="flaticon-restaurant"></span>Selección de menú</a>
                            </li>
                            <li class="submenu">
                                <a href="platillos.php" style="font-size: 1.4em;"><span class="flaticon-cutlery"></span>Platillos</a>
                            </li>
                            <li class="submenu">
                                <a href="tipos.php" style="font-size: 1.4em;"><span class="flaticon-people"></span>Tipos</a>
                            </li>
                            <li class="submenu">
                                <a href="pedidos.php" style="font-size: 1.4em;"><span class="flaticon-table"></span>Pedidos</a>
                            </li>
                        </ul>
                    </nav>
                </header>
            </div>
            <article>
                    <div class="contenedor">
                        <div class="barra-contenedor">
                            <p>Modificar tipo</p>
                            <a href="tipos.php">Cancelar</a>
                        </div>
                        <div class="informacion" style="background-color: #b0bec5;">
                            <!--Aqui va el codigo del contenido-->
                            <div class="formulario-nuevo">
                            <?php
                                include("conexion.php");
                                $id = $_REQUEST['id'];
                                $estado = "";
                                $sql = "SELECT * FROM tipos WHERE id = '$id'";
                                $respuesta = $conexion->query($sql);
                                $contacto = $respuesta->fetch_assoc();
                            ?>
                                <form action="modificar.php?id=<?php echo $contacto['id']; ?>&op=2" method="post">
                                    <fieldset>
                                        <legend>Datos  tipo</legend>
                                        <input type="text" value="<?php echo $contacto['tipo'];  ?>" name="nombre" placeholder="Nombre..." required="true">
                                        <select name="estado" id="" disabled="false">
                                        <?php 
                                            switch ($contacto['estado']) {
                                                case 'D':?>
                                                        <option value="default">Seleccione un estado</option>
                                                        <option value="activo" selected="selected">Disponible</option>
                                                        <option value="inactivo">No disponible</option>
                                                    <?php break;?>
                                               <?php  case 'N':?>
                                                        <option value="default">Seleccione un estado</option>
                                                        <option value="activo">Disponible</option>
                                                        <option value="inactivo" selected="selected">No disponible</option>
                                                    <?php break; ?>
                                         
                                            <?php } ?>
                                            </select>
                                    </fieldset>
                                    <input type="submit" value="Modificar" class="btn-guardar">
                                </form>
                            </div>
                        </div>
                    </div>
            </article>
        </section>
    </body>
</html>
