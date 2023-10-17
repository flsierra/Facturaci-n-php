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

$maxRows_Asociados_lis = 20;
$pageNum_Asociados_lis = 0;
if (isset($_GET['pageNum_Asociados_lis'])) {
  $pageNum_Asociados_lis = $_GET['pageNum_Asociados_lis'];
}
$startRow_Asociados_lis = $pageNum_Asociados_lis * $maxRows_Asociados_lis;

mysql_select_db($database_conexion, $conexion);
$query_Asociados_lis = "SELECT * FROM usuarios WHERE usuarios.rol ='3' ORDER BY usuarios.nombres_apellidos ASC";
$query_limit_Asociados_lis = sprintf("%s LIMIT %d, %d", $query_Asociados_lis, $startRow_Asociados_lis, $maxRows_Asociados_lis);
$Asociados_lis = mysql_query($query_limit_Asociados_lis, $conexion) or die(mysql_error());
$row_Asociados_lis = mysql_fetch_assoc($Asociados_lis);

if (isset($_GET['totalRows_Asociados_lis'])) {
  $totalRows_Asociados_lis = $_GET['totalRows_Asociados_lis'];
} else {
  $all_Asociados_lis = mysql_query($query_Asociados_lis);
  $totalRows_Asociados_lis = mysql_num_rows($all_Asociados_lis);
}
$totalPages_Asociados_lis = ceil($totalRows_Asociados_lis/$maxRows_Asociados_lis)-1;
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
   <h1>Lista de Asociados </h1>
   <p><a href="Asociados_add.php">Añadir Asociado<img src="../images/add.jpg" width="50" height="60"/></a></p>
   <p><a href="Asociados_search.php">Buscar Asociado <img src="../images/search.jpg" width="50" height="60"/></a></p>
   <table width="100%" border="1">
     <tr>
       <td width="40%" bgcolor="#999999"><em><strong>Nombres Y Apellidos</strong></em></td>
       <td width="13%" bgcolor="#999999"><em><strong>Cedula</strong></em></td>
       <td width="17%" bgcolor="#999999"><em><strong>Correo</strong></em></td>
       <td width="17%" bgcolor="#999999"><em><strong>Telefono</strong></em></td>
       <td width="17%" bgcolor="#999999"><em><strong>Direccion</strong></em></td>
       <td width="17%" bgcolor="#999999"><em><strong>Acciones</strong></em></td>
     </tr>
     <?php do { ?>
       <tr>
         <td><?php echo $row_Asociados_lis['nombres_apellidos']; ?></td>
         <td><?php echo $row_Asociados_lis['cedula']; ?></td>
         <td><?php echo $row_Asociados_lis['email']; ?></td>
         <td><?php echo $row_Asociados_lis['telefono']; ?></td>
         <td><?php echo $row_Asociados_lis['direccion']; ?></td>
         <td><a href="Asociados_edit.php?recordID=<?php echo $row_Asociados_lis['id_usuario']; ?>"><img src="../images/edit.jpg" width="21" height="20"/></a> / <a href="Asociados_delet.php?recordID=<?php echo $row_Asociados_lis['id_usuario']; ?>"><img src="../images/delet.jpg" width="21" height="20"/></a></td>
       </tr>
       <?php } while ($row_Asociados_lis = mysql_fetch_assoc($Asociados_lis)); ?>
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
mysql_free_result($Asociados_lis);
?>
