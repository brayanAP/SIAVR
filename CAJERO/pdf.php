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
<?php

function cambiar_estado_mesa($mesa){
    include("conexion.php");

    $sql = "UPDATE mesas SET estado = 'D' WHERE id = '$mesa'";

    $respuesta = $conexion->query($sql);

    if($respuesta){
        return true;
    }else{
        return false;
    }
}//CAMBIAR DE ESTADO MESA
/*
function insertar_completado($desc,$total,$fecha_incio){
    include("conexion.php");
    $sql = "INSERT INTO completados(desc,total,fecha_hora_inicio,fecha_hora_final)  VALUES ('$desc','$total','$fecha_incio',NOW())";
    $res = $conexion->query($sql);

    if($res){
        return true;
    }else{
        return false;
   }
}//insertar completado
*/
function desc_pedido($pedido){
    $desc = "";
    include("conexion.php");
    $sql = "SELECT tp.numero,pl.nombre,pl.precio FROM toma_pedido tp
        INNER JOIN pedidos P on p.id = tp.pedidos_id
        INNER JOIN platillos pl ON pl.id = tp.platillos_id
        WHERE p.id = '$pedido'";
                                        
    $respuesta = $conexion->query($sql);
    while($contacto= $respuesta->fetch_assoc()){ 
        $desc = $desc."\n".$contacto['numero']." - ".$contacto['nombre']." - "."$".$contacto['precio'].".00";              
    }
    return $desc;
}//descripcion del pedido

function contar_platillos($pedido){
    include("conexion.php");

    $res = $conexion->query("SELECT count(*) FROM toma_pedido WHERE pedidos_id = '$pedido'");

    if($res){
        $row = $res->fetch_row();
        return $row[0];
    }else{
        return false;
    }
}//buscar cantidad

function eliminar_toma($mesa,$pedido){
    include("conexion.php");

    $cant = contar_platillos($pedido);
    if($cant == false){
         return false;
    }

    $dx = 0;
    while ( $dx != $cant) {
         $sql = "DELETE FROM toma_pedido WHERE pedidos_id = '$pedido'";
        $respuesta = $conexion->query($sql);

        if($respuesta){
            $dx = $dx + 1;
        }else{
            return false;
        }
    }
    return true;
}//eliminar toma

function eliminar_pedido($mesa){
    include("conexion.php");
    $sql = "DELETE FROM pedidos WHERE mesas_id = '$mesa'";

        $respuesta = $conexion->query($sql);

        if($respuesta){
            return true;

        }else{
            return false;
        }
}//eliminar pedido

function calcular_total($pedido){
    include("conexion.php");

    $res = $conexion->query("SELECT SUM(pl.precio*tp.numero) AS 'total' FROM toma_pedido tp
        INNER JOIN pedidos p ON p.id = tp.pedidos_id
        INNER JOIN platillos pl ON pl.id = tp.platillos_id
        WHERE p.id = '$pedido'");

    if($res){
        $row = $res->fetch_row();
        return $row[0];
    }else{
        return false;
    }
}//buscar pedido

$pedido = $_REQUEST['pedido'];
$mesa = $_REQUEST['mesa'];

$de = desc_pedido($pedido);
$totaal = calcular_total($pedido);

require('fpdf/fpdf.php');

$pdf = new FPDF();
$pdf->AddPage('P','A3');
$pdf->SetFont('Arial','B',16);
$pdf->Cell(40,5,"SIAVR");
$pdf->Ln();
$pdf->Ln();
include("conexion.php");

$sqll = "SELECT tp.numero,pl.nombre,pl.precio FROM toma_pedido tp
        INNER JOIN pedidos P on p.id = tp.pedidos_id
        INNER JOIN platillos pl ON pl.id = tp.platillos_id
        WHERE p.id = '$pedido'";

$respuestaa = $conexion->query($sqll);
$pdf->SetFont('Arial','B',10);
while($contactoo= $respuestaa->fetch_assoc()){ 
    $pdf->Cell(40,5,"Cantidad: ".$contactoo['numero']);
    $pdf->Ln();
    $pdf->Cell(40,5,"Nombre: ".$contactoo['nombre']);
    $pdf->Ln();
    $pdf->Cell(40,5,"Precio: ".$contactoo['precio']);
    $pdf->Ln();
    $pdf->Cell(40,5,'********************');
    $pdf->Ln();
}
$pdf->Ln();
$pdf->Cell(40,5,'-----------------------');
$pdf->Ln();
$total ="TOTAL: "."$".$totaal.".00";
$pdf->Cell(40,5,$total);

$pdf->Output('I');

cambiar_estado_mesa($mesa);
eliminar_toma($mesa,$pedido);
eliminar_pedido($mesa);
?>