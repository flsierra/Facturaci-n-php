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

$maxRows_Lista_Inscr = 20;
$pageNum_Lista_Inscr = 0;
if (isset($_GET['pageNum_Lista_Inscr'])) {
  $pageNum_Lista_Inscr = $_GET['pageNum_Lista_Inscr'];
}
$startRow_Lista_Inscr = $pageNum_Lista_Inscr * $maxRows_Lista_Inscr;

mysql_select_db($database_conexion, $conexion);
$query_Lista_Inscr = "SELECT * FROM inscripcion";
$query_limit_Lista_Inscr = sprintf("%s LIMIT %d, %d", $query_Lista_Inscr, $startRow_Lista_Inscr, $maxRows_Lista_Inscr);
$Lista_Inscr = mysql_query($query_limit_Lista_Inscr, $conexion) or die(mysql_error());
$row_Lista_Inscr = mysql_fetch_assoc($Lista_Inscr);

if (isset($_GET['totalRows_Lista_Inscr'])) {
  $totalRows_Lista_Inscr = $_GET['totalRows_Lista_Inscr'];
} else {
  $all_Lista_Inscr = mysql_query($query_Lista_Inscr);
  $totalRows_Lista_Inscr = mysql_num_rows($all_Lista_Inscr);
}
$totalPages_Lista_Inscr = ceil($totalRows_Lista_Inscr/$maxRows_Lista_Inscr)-1;
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
   <h1>Lista de Valores de Inscripcion</h1>
   <p>&nbsp;</p>
   <table width="100%" border="1">
     <tr>
       <td bgcolor="#999999"><em><strong>Estado</strong></em></td>
       <td bgcolor="#999999"><em><strong>Valor</strong></em></td>
       <td bgcolor="#999999"><em><strong>Acciones</strong></em></td>
     </tr>
     <?php do { ?>
  <tr>
    <td><?php echo $row_Lista_Inscr['estado']; ?></td>
    <td> $ <?php echo $row_Lista_Inscr['values']; ?></td>
    <td><a href="Inscripcion_edit.php?recordID=<?php echo $row_Lista_Inscr['id_inscripcion']; ?>"><img src="../images/edit.jpg" width="21" height="30"/></a> / <a href="Inscripcion_delet.php?recordID=<?php echo $row_Lista_Inscr['id_inscripcion']; ?>"><img src="../images/delet.jpg" width="21" height="30"/></a></td>
  </tr>
  <?php } while ($row_Lista_Inscr = mysql_fetch_assoc($Lista_Inscr)); ?>
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
mysql_free_result($Lista_Inscr);
?>
