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

$maxRows_Sancion_list = 20;
$pageNum_Sancion_list = 0;
if (isset($_GET['pageNum_Sancion_list'])) {
  $pageNum_Sancion_list = $_GET['pageNum_Sancion_list'];
}
$startRow_Sancion_list = $pageNum_Sancion_list * $maxRows_Sancion_list;

mysql_select_db($database_conexion, $conexion);
$query_Sancion_list = "SELECT * FROM sancion";
$query_limit_Sancion_list = sprintf("%s LIMIT %d, %d", $query_Sancion_list, $startRow_Sancion_list, $maxRows_Sancion_list);
$Sancion_list = mysql_query($query_limit_Sancion_list, $conexion) or die(mysql_error());
$row_Sancion_list = mysql_fetch_assoc($Sancion_list);

if (isset($_GET['totalRows_Sancion_list'])) {
  $totalRows_Sancion_list = $_GET['totalRows_Sancion_list'];
} else {
  $all_Sancion_list = mysql_query($query_Sancion_list);
  $totalRows_Sancion_list = mysql_num_rows($all_Sancion_list);
}
$totalPages_Sancion_list = ceil($totalRows_Sancion_list/$maxRows_Sancion_list)-1;
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
   <h1>Listado de valores  Sanciones</h1>
   <p>&nbsp;</p>
   <table width="100%" border="1">
     <tr>
       <td bgcolor="#CCCCCC">Estado</td>
       <td bgcolor="#CCCCCC">Valor</td>
       <td bgcolor="#CCCCCC">Acciones</td>
     </tr>
     <?php do { ?>
       <tr>
         <td><?php echo $row_Sancion_list['estado']; ?></td>
         <td> $ <?php echo $row_Sancion_list['valores']; ?></td>
         <td><a href="Sancion_edit.php?recordID=<?php echo $row_Sancion_list['id_sancion']; ?>"><img src="../images/edit.jpg" width="31" height="30"/></a> / <a href="Sancion_delet.php?recordID=<?php echo $row_Sancion_list['id_sancion']; ?>"><img src="../images/delet.jpg" width="31" height="30"/></a></td>
       </tr>
       <?php } while ($row_Sancion_list = mysql_fetch_assoc($Sancion_list)); ?>
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
mysql_free_result($Sancion_list);
?>
