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
                            var ventana = confirm("¿Quieres eliminar este usuario?","");
                            return ventana;
                        }
                    </script>
                </header>
            </div>
            <article>
                    <div class="contenedor">
                        <div class="barra-contenedor">
                            <p>Administración de platillos</p>
                            <a href="nuevo_platillo.php">Nuevo</a>
                        </div>
                        <div class="informacion">
                            <!--Aqui va el codigo del contenido-->
                            <div class="tabla">
                                <table>
                                  <thead>
                                  <tr id="busqueda">
                                    <td colspan="8">
                                        <section id="barra-busqueda">
                                            <form action="buscar_platillos.php" method="post">          
                                                <input type="search" name="id" placeholder="Buscar...">               
                                                <button><i class="material-icons">search</i></button>
                                            </form>
                                        </section>
                                    </td>
                                  </tr>
                                  <tr>
                                    <td>Categoría</td>
                                    <td>Nombre</td>
                                    <td>Precio</td>
                                    <td>Estado</td>
                                    <td colspan="4">Acciones</td>           
                                  </tr>
                    
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

                                        function buscar_tipos($tipos_id){
                                            include("conexion.php");

                                            $res = $conexion->query("SELECT id FROM tipos WHERE tipo = '$tipos_id'");

                                            if($res){
                                                $row = $res->fetch_row();
                                                return $row[0];
                                            }else{
                                                return false;
                                            }
                                        }

                                        include("conexion.php");

                                        @$id = $_POST['id'];

                                        $id = strtoupper($id);

                                        $tipos_id = buscar_tipos($id);

                                        $sql = "SELECT * FROM platillos WHERE nombre LIKE '%$id%' OR estado LIKE '%$id%' OR tipos_id = '$tipos_id'";
                                        
                                        $respuesta = $conexion->query($sql);
                                        $fila = 0;
                                        $estado = "";

                                        while($contacto= $respuesta->fetch_assoc()){ 

                                            $tipos_id = buscar_tipo($contacto['tipos_id']);

                                            switch ($contacto['estado']) {
                                                case 'D':
                                                    $estado = "DISPONIBLE";
                                                    break;
                                                case 'N':
                                                    $estado = "NO DISPONIBLE";
                                                    break;
                                         
                                            }

                                            $fila++;
                                            if($fila%2==0){ ?> <tr bgcolor="#d8d8d8"> <?php }
                                            else{ ?> <tr bgcolor="#fff"> <?php }
                                            ?>
                                                <td><?php echo $tipos_id; ?></td>
                                                <td><?php echo $contacto['nombre'] ?></td>
                                                <td><?php echo "$".$contacto['precio'].".00" ?></td>

                                                <?php if($estado == "DISPONIBLE"){?>
                                                    <td style="border-left: 4px solid green;"><?php echo $estado; ?></td>
                                                <?php }else{ ?>
                                                    <td style="border-left: 4px solid red;"><?php echo $estado; ?></td>
                                                <?php } ?>
                                                    <td><a href="form_mod_platillo.php?id=<?php echo $contacto['id']; ?>"><i class="material-icons">mode_edit</i></a></td>
                                                    <td><a href="" onclick="return Eliminar();"><i class="material-icons">delete</i></a></td>
                                                <?php if($estado == "DISPONIBLE"){?>
                                                    <td><a href="cambiar_estado.php?id=<?php echo $contacto['id']; ?>&op=3"><i class="material-icons">star</i></a></td>
                                                <?php }else{ ?>
                                                    <td><a href="cambiar_estado.php?id=<?php echo $contacto['id']; ?>&op=3"><i class="material-icons">star_border</i></a></td>
                                                <?php } ?>
                                                <td><a href=""><i class="material-icons">open_in_new</i></a></td>
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
