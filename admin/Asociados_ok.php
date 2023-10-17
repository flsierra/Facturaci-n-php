<?php require_once('../Connections/conexion.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

$maxRows_Asociados_ok = 25;
$pageNum_Asociados_ok = 0;
if (isset($_GET['pageNum_Asociados_ok'])) {
  $pageNum_Asociados_ok = $_GET['pageNum_Asociados_ok'];
}
$startRow_Asociados_ok = $pageNum_Asociados_ok * $maxRows_Asociados_ok;

mysql_select_db($database_conexion, $conexion);
$query_Asociados_ok = "Select detalle_factura.id_detalle,detalle_factura.fecha_pago,detalle_factura.total_pago,usuarios.nombres_apellidos From detalle_factura,usuarios,deuda Where deuda.id_deuda = detalle_factura.id_deuda and detalle_factura.id_usuario = usuarios.id_usuario and deuda.estado = '2'";
$query_limit_Asociados_ok = sprintf("%s LIMIT %d, %d", $query_Asociados_ok, $startRow_Asociados_ok, $maxRows_Asociados_ok);
$Asociados_ok = mysql_query($query_limit_Asociados_ok, $conexion) or die(mysql_error());
$row_Asociados_ok = mysql_fetch_assoc($Asociados_ok);

if (isset($_GET['totalRows_Asociados_ok'])) {
  $totalRows_Asociados_ok = $_GET['totalRows_Asociados_ok'];
} else {
  $all_Asociados_ok = mysql_query($query_Asociados_ok);
  $totalRows_Asociados_ok = mysql_num_rows($all_Asociados_ok);
}
$totalPages_Asociados_ok = ceil($totalRows_Asociados_ok/$maxRows_Asociados_ok)-1;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/BaseAdmin.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<!-- InstanceBeginEditable name="doctitle" -->
<title>Sistema de Facturacion</title>
<!-- InstanceEndEditable -->
<!-- InstanceBeginEditable name="head" -->
<!-- InstanceEndEditable -->
<link href="../css/twoColLiqLtHdr.css" rel="stylesheet" type="text/css" />
<link rel="shorcut icon" href="../images/logo.png"/><!--[if lte IE 7]>
<style>
.content { margin-right: -1px; } /* este margen negativo de 1 px puede situarse en cualquiera de las columnas de este diseño con el mismo efecto corrector. */
ul.nav a { zoom: 1; }  /* la propiedad de zoom da a IE el desencadenante hasLayout que necesita para corregir el espacio en blanco extra existente entre los vínculos */
</style>
<![endif]-->
</head>

<body>
<div class="header"><div class="headerinterior"></div> </div>
<div class="container">
  <div class="sidebar1">
   <?php 
  include ("../includes/cabeceraadmin.php");
   ?>
   
    <!-- end .sidebar1 --></div>
  <div class="content"><!-- InstanceBeginEditable name="Contenido" -->
   <h1>Listado de Asociados al día</h1>
   <p><a href="Reportes.php">Volver a la Lista de Reportes</a></p>
   <p>&nbsp;</p>
   <table width="100%" border="1">
     <tr>
       <td bgcolor="#CCCCCC"><strong>Referencia de Pago</strong></td>
       <td bgcolor="#CCCCCC"><strong>Fecha de ultimo pago</strong></td>
       <td bgcolor="#CCCCCC"><strong>Asociado</strong></td>
     </tr>
     <?php do { ?>
       <tr>
         <td><?php echo $row_Asociados_ok['id_detalle']; ?></td>
         <td><?php echo $row_Asociados_ok['fecha_pago']; ?></td>
         <td><?php echo $row_Asociados_ok['nombres_apellidos']; ?></td>
       </tr>
       <?php } while ($row_Asociados_ok = mysql_fetch_assoc($Asociados_ok)); ?>
   </table>
   <p>&nbsp;</p>
  
  <!-- InstanceEndEditable -->
  <!-- end .content --></div>
  <div class="footer">
   <center> <p><strong>Copyright  &copy;2019 ASOCUCAITA TV</strong></p>
   <p>ELABORADO POR: <a link href="https://www.facebook.com/PI-Technological-106580044158085/?epa=SEARCH_BOX"> PI TECHONOLOGICAL</a></p>
   </center>
  <!-- end .footer --></div>
  <!-- end .container --></div>
</body>
<!-- InstanceEnd --></html>
<?php
mysql_free_result($Asociados_ok);
?>
