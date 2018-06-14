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

                    <script>
                        function Eliminar(){
                            var ventana = confirm("¿Quieres eliminar este platillo?","");
                            return ventana;
                        }
                    </script>
                </header>
            </div>
            <article>
                    <div class="contenedor">
                        <div class="barra-contenedor">
                            <p>Visualizar menú</p>
                            <a href="index.php">Salir</a>
                        </div>
                        <div class="informacion">
                            <!--Aqui va el codigo del contenido-->
                            <div class="tabla">
                                <table>
                                  <thead>
                                    <td>Tipo</td>
                                    <td>Nombre</td>
                                    <td>Precio</td>
                                    <td colspan="1">Acciones</td>
                                  </thead>
                                  <tbody>
                                    <?php 
                                        function buscar_tipo($tipos_id){
                                            include("conexion.php");

                                            $res = $conexion->query("SELECT tipo FROM tipos WHERE id = '$tipos_id'");

                                            if($res){
                                                $row = $res->fetch_row();
                                                return $row[0];
                                            }else{
                                                return false;
                                            }
                                        }
                                        $id = $_REQUEST['id'];
                                        include("conexion.php");

                                        $sql = "SELECT * FROM platillos_menu WHERE menus_id = '$id'";
                                        $respuesta = $conexion->query($sql);
                                        $fila = 0;
                                        while($contacto= $respuesta->fetch_assoc()){ 

                                            $fila++;
                                            if($fila%2==0){ ?> <tr bgcolor="#d8d8d8"> <?php }
                                            else{ ?> <tr bgcolor="#fff"> <?php }
                                            ?>
                                            <?php 
                                                include("conexion.php");
                                                $estado = "";
                                                $platillos_id = $contacto['platillos_id'];
                                                $sql = "SELECT * FROM platillos WHERE id = '$platillos_id'";
                                                $res = $conexion->query($sql);
                                                $platillo = $res->fetch_assoc();
                                                $tipos_id = buscar_tipo($platillo['tipos_id']);
                                            ?>
                                                <td><?php echo $tipos_id ?></td>
                                                <td><?php echo $platillo['nombre'] ?></td>
                                                <td><?php echo "$".$platillo['precio'].".00" ?></td>


                                                    <td><a href="eliminar.php?id=<?php echo $platillo['id']; ?>&op=4&men=<?php echo $id ?>" ><i class="material-icons">delete</i></a></td>
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