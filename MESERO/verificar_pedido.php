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

        <script>
                        function Eliminar(){
                            var ventana = confirm("¿En realidad, quieres quitar el platillo?","");
                            return ventana;
                        }
                    </script>

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
                            <p>Verificar pedido</p>
                            <a href="index.php">Cancelar</a>
                        </div>
                        <div class="informacion">
                            <!--Aqui va el codigo del contenido-->
                            <div class="tabla">
                                <table>
                                  <thead>
                                  <tr>
                                    <td>Cantidad</td>
                                    <td>Categoría</td>
                                    <td>Nombre</td>
                                    <td>Observación</td>
                                    <td>Precio</td>
                                    <td>Acciones</td>           
                                  </tr>
                    
                                  </thead>
                                  <tbody>
                                    <?php 
                                        $mesa = $_REQUEST['id'];
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
                                        include("conexion.php");

                                        $sql = "SELECT pl.id AS 'idPl',pl.nombre AS 'nombrep',pl.precio AS 'preciop',pl.tipos_id AS 'tipoidP',p.id AS 'idP',t.numero AS 'cantidad',t.descripcion AS 'observacion' FROM platillos pl
                                            INNER JOIN mesas m ON m.id = '$mesa'
                                            INNER JOIN pedidos p ON p.mesas_id = m.id
                                            INNER JOIN toma_pedido t ON t.pedidos_id = p.id AND t.platillos_id = pl.id";
                                        $respuesta = $conexion->query($sql);
                                        $fila = 0;
                                        while($contacto= $respuesta->fetch_assoc()){ 

                                            $tipos_id = buscar_tipo($contacto['tipoidP']);

                                            $fila++;
                                            if($fila%2==0){ ?> <tr bgcolor="#d8d8d8"> <?php }
                                            else{ ?> <tr bgcolor="#fff"> <?php }
                                            ?>  
                                                <td><?php echo $contacto['cantidad']  ?></td>
                                                <td><?php echo $tipos_id; ?></td>
                                                <td><?php echo $contacto['nombrep'] ?></td>
                                                <td><?php echo $contacto['observacion'] ?></td>
                                                <td><?php echo "$".$contacto['preciop'].".00" ?></td>
                                                <td><a href="elimar_platillo_pedido.php?mesa=<?php echo $mesa; ?>&pedido=<?php echo $contacto['idP']; ?>&platillo=<?php echo $contacto['idPl']  ?>" onclick="return Eliminar();"><i class="material-icons">delete</i></a></td>
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
