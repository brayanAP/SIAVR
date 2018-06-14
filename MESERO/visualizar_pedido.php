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
    <body style="background-color: #eceff1;">
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
                                <a href="index.php" style="font-size: 1.4em;"><span class="flaticon-table"></span>Mesas</a>
                            </li>
                            <li class="submenu">
                                <a href="observaciones.php" style="font-size: 1.4em;"><span class="flaticon-restaurant"></span>Observaciones</a>
                            </li>
                            <li class="submenu">
                                <a href="pedidos.php" style="font-size: 1.4em;"><span class="flaticon-restaurant-5"></span>Pedidos</a>
                            </li>
                        </ul>
                    </nav>
                </header>
            </div>
            <article>
                    <div class="contenedor">
                        <div class="barra-contenedor">
                            <p>Visualizar pedido</p>
                            <a href="pedidos.php">Salir</a>
                        </div>
                        <div class="informacion" style="background-color: #b0bec5;">
                            <!--Aqui va el codigo del contenido-->
                            <div class="tabla">
                                <table>
                                  <thead>
                                  <tr> 
                                    <td>Cantidad</td>
                                    <td>Categoria</td>
                                    <td>Nombre</td>
                                    <td>Observación</td>       
                                  </tr>
                    
                                  </thead>
                                  <tbody>
                                    <?php 
                                        include("conexion.php");
                                        $pedido = $_REQUEST['pedido'];
                                        $sql = "SELECT ti.tipo AS 'categoria',pl.nombre AS 'nombre',tp.numero AS 'cantidad',tp.descripcion FROM pedidos pe
                                                INNER JOIN toma_pedido tp ON tp.pedidos_id = pe.id
                                                INNER JOIN platillos pl ON pl.id = tp.platillos_id
                                                INNER JOIN tipos ti ON ti.id = pl.tipos_id
                                                WHERE pe.id = '$pedido'";
                                        $fila = 0;
                                        $respuesta = $conexion->query($sql);
                                        while($contacto= $respuesta->fetch_assoc()){ 
                                            $fila++;
                                            if($fila%2==0){ ?> <tr bgcolor="#d8d8d8"> <?php }
                                            else{ ?> <tr bgcolor="#fff"> <?php }
                                            ?>
                                            <td><?php echo $contacto['cantidad'] ?></td>
                                            <td><?php echo $contacto['categoria'] ?></td>
                                            <td><?php echo $contacto['nombre'] ?></td>
                                            <td><?php echo $contacto['descripcion'] ?></td>
                                            </tr>
                                        <?php } ?>      
                                  </tbody>
                                </table>
                              </div>
                        </div>
                    </div>
            </article>
        </section>
    </body>
</html>
