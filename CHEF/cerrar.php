<?php 
	function Cerrar_sesion(){
	session_start();
	session_destroy();
	header("Location: ../LOGIN/index.html");
}

Cerrar_sesion();
?>