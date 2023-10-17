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

$currentPage = $_SERVER["PHP_SELF"];

$maxRows_Pagos_list = 20;
$pageNum_Pagos_list = 0;
if (isset($_GET['pageNum_Pagos_list'])) {
  $pageNum_Pagos_list = $_GET['pageNum_Pagos_list'];
}
$startRow_Pagos_list = $pageNum_Pagos_list * $maxRows_Pagos_list;

mysql_select_db($database_conexion, $conexion);
$query_Pagos_list = "SELECT medio_pago.id_medio,medio_pago.oficina,medio_pago.direccion,medio_pago.fecha,detalle_factura.id_detalle,detalle_factura.total_pago FROM medio_pago,detalle_factura Where medio_pago.id_detalle = detalle_factura.id_detalle";
$query_limit_Pagos_list = sprintf("%s LIMIT %d, %d", $query_Pagos_list, $startRow_Pagos_list, $maxRows_Pagos_list);
$Pagos_list = mysql_query($query_limit_Pagos_list, $conexion) or die(mysql_error());
$row_Pagos_list = mysql_fetch_assoc($Pagos_list);

if (isset($_GET['totalRows_Pagos_list'])) {
  $totalRows_Pagos_list = $_GET['totalRows_Pagos_list'];
} else {
  $all_Pagos_list = mysql_query($query_Pagos_list);
  $totalRows_Pagos_list = mysql_num_rows($all_Pagos_list);
}
$totalPages_Pagos_list = ceil($totalRows_Pagos_list/$maxRows_Pagos_list)-1;

$queryString_Pagos_list = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_Pagos_list") == false && 
        stristr($param, "totalRows_Pagos_list") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_Pagos_list = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_Pagos_list = sprintf("&totalRows_Pagos_list=%d%s", $totalRows_Pagos_list, $queryString_Pagos_list);
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
   <h1>Listado de Pagos Registrados</h1>
   <p><a href="Pago_add.php">Realizar Nuevo Pago<img src="../images/add.jpg" alt="" width="50" height="60"/></a></p>
   <p><a href="Pago_search.php">Buscar Pagos</a> <a href="Usuarios_search.php"><img src="../images/search.jpg" alt="" width="50" height="60"/></a></p>
   <table width="100%" border="1">
     <tr>
       <td bgcolor="#CCCCCC"><strong>Oficina</strong></td>
       <td bgcolor="#CCCCCC"><strong>Direccion</strong></td>
       <td bgcolor="#CCCCCC"><strong>Fecha Pago</strong></td>
       <td bgcolor="#CCCCCC"><strong>Referencia de pago</strong></td>
       <td bgcolor="#CCCCCC"><strong>Valor a Pagar</strong></td>
       <td bgcolor="#CCCCCC"><strong>Acciones</strong></td>
     </tr>
     <?php do { ?>
       <tr>
         <td><?php echo $row_Pagos_list['oficina']; ?></td>
         <td><?php echo $row_Pagos_list['direccion']; ?></td>
         <td><?php echo $row_Pagos_list['fecha']; ?></td>
         <td><?php echo $row_Pagos_list['id_detalle']; ?></td>
         <td> $ <?php echo $row_Pagos_list['total_pago']; ?></td>
         <td><a href="Pago_edit.php?recordID=<?php echo $row_Pagos_list['id_medio']; ?>"><img src="../images/edit.jpg" width="21" height="20"/></a> / <a href="Pago_delet.php?recordID=<?php echo $row_Pagos_list['id_medio']; ?>"><img src="../images/delet.jpg" width="21" height="20"/></a></td>
       </tr>
       <?php } while ($row_Pagos_list = mysql_fetch_assoc($Pagos_list)); ?>
   </table>
   <p>&nbsp;   
   <table border="0">
     <tr>
       <td><?php if ($pageNum_Pagos_list > 0) { // Show if not first page ?>
           <a href="<?php printf("%s?pageNum_Pagos_list=%d%s", $currentPage, 0, $queryString_Pagos_list); ?>">Primero</a>
           <?php } // Show if not first page ?></td>
       <td><?php if ($pageNum_Pagos_list > 0) { // Show if not first page ?>
           <a href="<?php printf("%s?pageNum_Pagos_list=%d%s", $currentPage, max(0, $pageNum_Pagos_list - 1), $queryString_Pagos_list); ?>">Anterior</a>
           <?php } // Show if not first page ?></td>
       <td><?php if ($pageNum_Pagos_list < $totalPages_Pagos_list) { // Show if not last page ?>
           <a href="<?php printf("%s?pageNum_Pagos_list=%d%s", $currentPage, min($totalPages_Pagos_list, $pageNum_Pagos_list + 1), $queryString_Pagos_list); ?>">Siguiente</a>
           <?php } // Show if not last page ?></td>
       <td><?php if ($pageNum_Pagos_list < $totalPages_Pagos_list) { // Show if not last page ?>
           <a href="<?php printf("%s?pageNum_Pagos_list=%d%s", $currentPage, $totalPages_Pagos_list, $queryString_Pagos_list); ?>">&Uacute;ltimo</a>
           <?php } // Show if not last page ?></td>
     </tr>
   </table>
   </p>
  
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
mysql_free_result($Pagos_list);
?>
