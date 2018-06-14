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
        <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
        <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.2/jquery-ui.min.js"></script>
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Patua+One|Source+Sans+Pro" rel="stylesheet">
        <link rel="stylesheet" href="font/flaticon.css">
        <script src="../GENERALES/js/main.js"></script>
        <link rel="stylesheet" href="../GENERALES/css/menu.css">
        <script src="../GENERALES/js/menu.js"></script>
        <link rel="stylesheet" href="../GENERALES/css/estilos.css">
        <link rel="stylesheet" href="css/admin.css">

        <script>
            $(document).ready(function(){
            $( "#lista1 li, #lista2 li" ).draggable({
                appendTo: "body",helper: 'clone',
            });

            $( "#lista2, #lista1" ).droppable({
                accept:'li',
                activeClass: "ui-state-default",
                hoverClass: "ui-state-hover",
             
                drop: function( event, ui ) {
                    ui.draggable.appendTo(this).fadeIn();
                }
            });

            function obtenerDatos(){
                //Se crea la variable para la lista de idiomas seleccionados
                var idplatillos ="";
                //Se obtiene todos los elementos li de la lista con id="idiomasseleccionados" y se recorren
                // utilizando el método .each
                $( "#lista2 li" ).each(function (i) {
                    // Se agrega a la variable idiomas el valor del atributo id y se le agrega una coma al final
                    // para separar cada idioma
                    idplatillos += $(this).attr('id')+",";
                });
                // Se almacenan todos los datos en un arreglo
                datos = [{name:"idplatillos", value:idplatillos}];
                // Se regresa la variable datos con toda la informacion del alumno
                return datos;
            }

            $("#form_select_pla_men").submit(function(){
                    //Funcion para obtener los valores del formulario se explica mas adelante
                    datos = obtenerDatos();
                    $.ajax({
                      url:'seleccion_guardar.php', //URL del archivo php que procesa la petición. Se explica mas adelante
                      type:'post', // Los datos se envían mediante el método POST
                      dataType:'json', // La respuesta se obtiene como JSON
                      data:datos // Los datos del formulario
                    }).done(function(respuesta){
                        //Condición para verificar si se guardaron o no los datos
                        if( respuesta.estado == true )
                            alert("Menú guardado con éxito.");
                        else
                          alert("ERROR: No se pudo guardar el menú.");
                    });
                    return false; // Se regresa false para el que submit no se ejecute.
                });
            });

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
                            <p>Selección de menú</p>
                            <a href="index.php">Cancelar</a>
                        </div>
                        <div class="informacion">
                            <!--Aqui va el codigo del contenido-->
                            <div class="formulario-nuevo">
                                <form action="seleccion_2.php" method="post">
                                    <fieldset style="height: 47vh;">
                                        <legend>Datos  Menú</legend>
                                        <select name="menu">
                                            <option value="default">Seleccione un menú</option>
                                            <?php 
                                            include("conexion.php");

                                            $sql = "SELECT * FROM menus";
                                            $respuesta = $conexion->query($sql);
                                            $fila = 0;
                                            $estado = "";
                                            while($contacto= $respuesta->fetch_assoc()){ ?>  
                                                <?php if($contacto['estado'] == "D"){?>
                                                    <option value="<?php echo $contacto['id']; ?>"><?php echo $contacto['nombre']; ?></option>
                                                <?php } ?>
                                            <?php } ?>   
                                        </select>
                                        <select name="tipo">
                                            <option value="default">Seleccione un tipo</option>
                                            <?php 
                                            include("conexion.php");

                                            $sql = "SELECT * FROM tipos";
                                            $respuesta = $conexion->query($sql);
                                            $fila = 0;
                                            $estado = "";
                                            while($contacto= $respuesta->fetch_assoc()){ ?>  
                                                <?php if($contacto['estado'] == "D"){?>
                                                    <option value="<?php echo $contacto['id']; ?>"><?php echo $contacto['tipo']; ?></option>
                                                <?php } ?>
                                            <?php } ?>   
                                        </select>     
                                    </fieldset>
                                    <input type="submit" value="Seleccionar" class="btn-guardar">
                                </form>
                            </div>

                        </div>
                    </div>
            </article>
        </section>
    </body>
</html>

