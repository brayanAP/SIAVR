<?php 
     if(!isset($_SESSION)) 
    { 
        session_start(); 
    }

    if(isset($_SESSION['user']) and isset($_SESSION['pass']) and isset($_SESSION['cargo'])){
        if($_SESSION['cargo'] != 3){
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
                            <li class="submenu">
                                <a href="cobros.php" style="font-size: 1.4em;"><span class="flaticon-restaurant-2"></span>Cuenta</a>
                            </li>
                        </ul>
                    </nav>
                </header>
            </div>
            <article>
                    <div class="contenedor">
                        <div class="barra-contenedor">
                            <p>Cuenta</p>
                            <a href="index.php">Cancelar</a>
                        </div>
                        <div class="informacion" style="background-color: #b0bec5;">
                            <!--Aqui va el codigo del contenido-->
                            <div class="tabla">
                                <table>
                                  <thead>
                                  <tr>
                                    <td>Pedido</td>
                                    
                                    <td>Mesa</td>
                                    <td>Estado</td>
                                    <td colspan="4">Acciones</td>           
                                  </tr>
                    
                                  </thead>
                                  <tbody>
                                    <?php 
                                        include("conexion.php");

                                        $sql = "SELECT p.id AS 'idPedido', p.estado AS 'estadoP',m.id AS 'idMesa',u.id AS 'idUsuario' FROM pedidos p
                                            INNER JOIN mesas m ON m.id = p.mesas_id
                                            INNER JOIN usuarios u ON u.id = p.usuarios_id
                                            WHERE NOT( p.estado = 'S' OR p.estado = 'M')";
                                        $respuesta = $conexion->query($sql);
                                        $fila = 0;
                                        $estado = "";
                                        while($contacto= $respuesta->fetch_assoc()){ 

                                            switch ($contacto['estadoP']) {
                                                case 'L':
                                                    $estado = "LISTO";
                                                    break;
                                                case 'E':
                                                    $estado = "ESPERA";
                                                    break;
                                                 case 'P':
                                                    $estado = "PREPARANDO";
                                                    break;
                                                case 'S':
                                                    $estado = "PAGADO";
                                                    break;
                                            }

                                            $fila++;
                                            if($fila%2==0){ ?> <tr bgcolor="#d8d8d8"> <?php }
                                            else{ ?>
                                        <tr bgcolor="#fff"> 
                                        <?php }?>
                                            <td><?php echo $contacto['idPedido']; ?></td>
                                            
                                            <td><?php echo $contacto['idMesa']; ?></td>
                                            <?php if($estado == "LISTO"){?>
                                                <td style="border-left: 4px solid green;"><?php echo $estado; ?></td>
                                            <?php }  ?>
                                            <?php if($estado == "ESPERA"){?>
                                                <td style="border-left: 4px solid red;"><?php echo $estado; ?></td>
                                                
                                            <?php }  ?>
                                            <?php if($estado == "PREPARANDO"){?>
                                                <td style="border-left: 4px solid orange;"><?php echo $estado; ?></td>
                                                
                                            <?php }  ?>
                                            
                                            <td><a href="pdf.php?pedido=<?php echo $contacto['idPedido']; ?>&mesa=<?php echo $contacto['idMesa']; ?>"><i class="material-icons">monetization_on</i></a></td
                                               
                                        <?php } ?>    
                                        </tr>  
                                  </tbody>
                                </table>
                              </div>
                        </div>
                    </div>
            </article>
        </section>
    </body>
</html>
