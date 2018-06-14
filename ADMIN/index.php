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
        <script src="../GENERALES/push/push.min.js"></script>
        <script>
            Notification.requestPermission();

// Utilidad para lanzar la notificación

// Lanzar la notificación
spawnNotification("Esto es el cuerpo", undefined, "Título");
        </script>
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
                                <a href="index.php" style="font-size: 1.4em;"><span class="flaticon-badge"></span>Usuarios</a>

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
                            <p>Administracion de usuarios</p>
                            <a href="form_nuevo_usario.html">Nuevo</a>
                        </div>
                        <div class="informacion">
                            <!--Aqui va el codigo del contenido-->
                            <div class="tabla">
                                <table>
                                  <thead>
                                    <td>Usuario</td>
                                    <td>Nombres</td>
                                    <td>Cargo</td>
                                    <td>Estado</td>
                                    <td colspan="4">Acciones</td>
                                  </thead>
                                  <tbody>
                                    <?php 
                                        include("conexion.php");

                                        $sql = "SELECT * FROM usuarios";
                                        $respuesta = $conexion->query($sql);
                                        $fila = 0;
                                        $cargo = "";
                                        $estado = "";
                                        while($contacto= $respuesta->fetch_assoc()){ 

                                            switch ($contacto['estado']) {
                                                case 'D':
                                                    $estado = "DISPONIBLE";
                                                    break;
                                                case 'N':
                                                    $estado = "NO DISPONIBLE";
                                                    break;
                                         
                                            }

                                            switch ($contacto['cargos_id']) {
                                                case 1:
                                                    $cargo = 'ADMIN';
                                                    break;

                                                case 2:
                                                    $cargo = 'CHEF';
                                                    break;

                                                case 3:
                                                    $cargo = 'CAJERO';
                                                    break;

                                                case 4:
                                                    $cargo = 'MESERO';
                                                    break;
                                           }

                                            $fila++;
                                            if($fila%2==0){ ?> <tr bgcolor="#d8d8d8"> <?php }
                                            else{ ?> <tr bgcolor="#fff"> <?php }
                                            ?>
                                                <td><?php echo $contacto['username'] ?></td>
                                                <td><?php echo $contacto['nombreC'] ?></td>
                                                <td><?php echo $cargo; ?></td>

                                                <?php if($estado == "DISPONIBLE"){?>
                                                    <td style="border-left: 4px solid green;"><?php echo $estado; ?></td>
                                                <?php }else{ ?>
                                                    <td style="border-left: 4px solid red;"><?php echo $estado; ?></td>
                                                <?php } ?>
                                                    <td><a href="form_modificar_usuario.php?id=<?php echo $contacto['id']; ?>&car=<?php echo $contacto['cargos_id']  ?>"><i class="material-icons">mode_edit</i></a></td>
                                                    <td><a href="eliminar.php?id=<?php echo $contacto['id']; ?>&car=<?php echo $contacto['cargos_id']  ?>" onclick="return Eliminar();"><i class="material-icons">delete</i></a></td>
                                                <?php if($estado == "DISPONIBLE"){?>
                                                    <td><a href="cambiar_estado.php?id=<?php echo $contacto['id']; ?>&car=<?php echo $contacto['cargos_id']  ?>"><i class="material-icons">star</i></a></td>
                                                <?php }else{ ?>
                                                    <td><a href="cambiar_estado.php?id=<?php echo $contacto['id']; ?>&car=<?php echo $contacto['cargos_id']  ?>"><i class="material-icons">star_border</i></a></td>
                                                <?php } ?>

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
