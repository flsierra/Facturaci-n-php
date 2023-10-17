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

$maxRows_Deudas_list = 20;
$pageNum_Deudas_list = 0;
if (isset($_GET['pageNum_Deudas_list'])) {
  $pageNum_Deudas_list = $_GET['pageNum_Deudas_list'];
}
$startRow_Deudas_list = $pageNum_Deudas_list * $maxRows_Deudas_list;

mysql_select_db($database_conexion, $conexion);
$query_Deudas_list = "SELECT * FROM deuda";
$query_limit_Deudas_list = sprintf("%s LIMIT %d, %d", $query_Deudas_list, $startRow_Deudas_list, $maxRows_Deudas_list);
$Deudas_list = mysql_query($query_limit_Deudas_list, $conexion) or die(mysql_error());
$row_Deudas_list = mysql_fetch_assoc($Deudas_list);

if (isset($_GET['totalRows_Deudas_list'])) {
  $totalRows_Deudas_list = $_GET['totalRows_Deudas_list'];
} else {
  $all_Deudas_list = mysql_query($query_Deudas_list);
  $totalRows_Deudas_list = mysql_num_rows($all_Deudas_list);
}
$totalPages_Deudas_list = ceil($totalRows_Deudas_list/$maxRows_Deudas_list)-1;
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
   <h1>Listado de Valores Deudas</h1>
   <p><a href="Deudas_add.php">Añadir Valores de Deudas<img src="../images/add.jpg" width="50" height="60"/></a></p>
   <p>&nbsp;</p>
   <table width="100%" border="1">
     <tr>
       <td bgcolor="#CCCCCC"><em><strong>Estado</strong></em></td>
       <td bgcolor="#CCCCCC"><em><strong>Valor</strong></em></td>
       <td bgcolor="#CCCCCC"><em><strong>Acciones</strong></em></td>
     </tr>
     <?php do { ?>
       <tr>
         <td><?php echo $row_Deudas_list['estado']; ?></td>
         <td> $ <?php echo $row_Deudas_list['value']; ?></td>
         <td><a href="Deuda_edit.php?recordID=<?php echo $row_Deudas_list['id_deuda']; ?>"><img src="../images/edit.jpg" width="31" height="30"/></a> / <img src="../images/delet.jpg" width="31" height="30"/></td>
       </tr>
       <?php } while ($row_Deudas_list = mysql_fetch_assoc($Deudas_list)); ?>
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
mysql_free_result($Deudas_list);
?>
