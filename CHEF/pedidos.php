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
							<p>Administración de pedidos</p>
							<a href="pedidos.php" style="width: 200px;">Actualizar</a>
						</div>
						<div class="informacion">
							<!--Aqui va el codigo del contenido-->
							 <div class="tabla">
                                <table>
                                  <thead>
                                  <tr>
                                    <td>Pedido</td>
                                    <td>Usuario</td>
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
                                            }

                                            $fila++;
                                            if($fila%2==0){ ?> <tr bgcolor="#d8d8d8"> <?php }
                                            else{ ?> <tr bgcolor="#fff"> <?php }
                                            ?>
                                        	<td><?php echo $contacto['idPedido']; ?></td>
                                        	<td><?php echo $contacto['idUsuario']; ?></td>
                                        	<td><?php echo $contacto['idMesa']; ?></td>
                                        	<?php if($estado == "LISTO"){?>
                                        		<td style="border-left: 4px solid green;"><?php echo $estado ?></td>
                                        		<td><a href="estado_pedidos.php?pedido=<?php echo $contacto['idPedido']; ?>&op=1"><i class="material-icons">star_half</i></a></td>
                                        		<td><a href="estado_pedidos.php?pedido=<?php echo $contacto['idPedido']; ?>&op=2"><i class="material-icons">star_border</i></a></td>
                                        	<?php }  ?>
                                        	<?php if($estado == "ESPERA"){?>
                                        		<td style="border-left: 4px solid red;"><?php echo $estado ?></td>
                                        		<td><a href="estado_pedidos.php?pedido=<?php echo $contacto['idPedido']; ?>&op=3"><i class="material-icons">star</i></a></td>
                                        		<td><a href="estado_pedidos.php?pedido=<?php echo $contacto['idPedido']; ?>&op=1"><i class="material-icons">star_half</i></a></td>
                                        	<?php }  ?>
                                        	<?php if($estado == "PREPARANDO"){?>
                                        		<td style="border-left: 4px solid orange;"><?php echo $estado ?></td>
                                        		<td><a href="estado_pedidos.php?pedido=<?php echo $contacto['idPedido']; ?>&op=3"><i class="material-icons">star</i></a></td>
                                        		<td><a href="estado_pedidos.php?pedido=<?php echo $contacto['idPedido']; ?>&op=2"><i class="material-icons">star_border</i></a></td>
                                        	<?php }  ?>
                                        	<td><a href="visualizar_pedido.php?pedido=<?php echo $contacto['idPedido']; ?>"><i class="material-icons">open_in_new</i></a></td>
                                               
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
