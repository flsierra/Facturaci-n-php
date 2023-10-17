<?php require_once('../Connections/conexion.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "1";
$MM_donotCheckaccess = "false";

// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
  // For security, start by assuming the visitor is NOT authorized. 
  $isValid = False; 

  // When a visitor has logged into this site, the Session variable MM_Username set equal to their username. 
  // Therefore, we know that a user is NOT logged in if that Session variable is blank. 
  if (!empty($UserName)) { 
    // Besides being logged in, you may restrict access to only certain users based on an ID established when they login. 
    // Parse the strings into arrays. 
    $arrUsers = Explode(",", $strUsers); 
    $arrGroups = Explode(",", $strGroups); 
    if (in_array($UserName, $arrUsers)) { 
      $isValid = true; 
    } 
    // Or, you may restrict access to only certain users based on their username. 
    if (in_array($UserGroup, $arrGroups)) { 
      $isValid = true; 
    } 
    if (($strUsers == "") && false) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}

$MM_restrictGoTo = "../Login/Privilegios.php";
if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($_SERVER['QUERY_STRING']) && strlen($_SERVER['QUERY_STRING']) > 0) 
  $MM_referrer .= "?" . $_SERVER['QUERY_STRING'];
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo); 
  exit;
}
?>
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

$maxRows_Lista_fac = 1;
$pageNum_Lista_fac = 0;
if (isset($_GET['pageNum_Lista_fac'])) {
  $pageNum_Lista_fac = $_GET['pageNum_Lista_fac'];
}
$startRow_Lista_fac = $pageNum_Lista_fac * $maxRows_Lista_fac;

mysql_select_db($database_conexion, $conexion);
$query_Lista_fac = "SELECT detalle_factura.id_detalle, detalle_factura.fecha_pago, detalle_factura.soporte, usuarios.nombres_apellidos, deuda.value, mensualidad.mes, inscripcion.values, sancion.valores, reconexion.valor, detalle_factura.total_pago FROM detalle_factura,usuarios,deuda,mensualidad,inscripcion,sancion,reconexion where detalle_factura.id_usuario =usuarios.id_usuario and detalle_factura.id_deuda =deuda.id_deuda and detalle_factura.id_mensualidad= mensualidad.id_mensualidad and detalle_factura.id_inscripcion= inscripcion.id_inscripcion and detalle_factura.id_sancion = sancion.id_sancion and detalle_factura.id_reconexion = reconexion.id_reconexion";
$query_limit_Lista_fac = sprintf("%s LIMIT %d, %d", $query_Lista_fac, $startRow_Lista_fac, $maxRows_Lista_fac);
$Lista_fac = mysql_query($query_limit_Lista_fac, $conexion) or die(mysql_error());
$row_Lista_fac = mysql_fetch_assoc($Lista_fac);

if (isset($_GET['totalRows_Lista_fac'])) {
  $totalRows_Lista_fac = $_GET['totalRows_Lista_fac'];
} else {
  $all_Lista_fac = mysql_query($query_Lista_fac);
  $totalRows_Lista_fac = mysql_num_rows($all_Lista_fac);
}
$totalPages_Lista_fac = ceil($totalRows_Lista_fac/$maxRows_Lista_fac)-1;

$queryString_Lista_fac = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_Lista_fac") == false && 
        stristr($param, "totalRows_Lista_fac") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_Lista_fac = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_Lista_fac = sprintf("&totalRows_Lista_fac=%d%s", $totalRows_Lista_fac, $queryString_Lista_fac);
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
   <h1>Listado de Facturas</h1>
   <p><a href="Facturas_add.php">Añadir Facturas<img src="../images/add.jpg" alt="" width="50" height="60"/></a></p>
   <p><a href="Facturas_search.php">Buscar Facturas</a> <a href="Usuarios_search.php"><img src="../images/search.jpg" alt="" width="50" height="60"/></a></p>
   <?php do { ?>
   <table width="100%" border="1">
     <tr>
       <td width="56%" bgcolor="#CCCCCC">Referencia de Pago</td>
       <td width="44%"><?php echo $row_Lista_fac['id_detalle']; ?></td>
     </tr>
     <tr>
       <td bgcolor="#CCCCCC">Fecha de Pago</td>
       <td><?php echo $row_Lista_fac['fecha_pago']; ?></td>
     </tr>
     <tr>
       <td bgcolor="#CCCCCC">Factura Electronica</td>
       <td><a href="factura.php?recordID=<?php echo $row_Lista_fac['id_detalle']; ?>"><?php echo $row_Lista_fac['soporte']; ?></a></td>
     </tr>
     <tr>
       <td bgcolor="#CCCCCC">Datos Asociado</td>
       <td><?php echo $row_Lista_fac['nombres_apellidos']; ?></td>
     </tr>
     <tr>
       <td bgcolor="#CCCCCC">Mes a facturar</td>
       <td><?php echo $row_Lista_fac['mes']; ?></td>
     </tr>
     <tr>
       <td bgcolor="#CCCCCC">Valores de Deuda</td>
       <td>$ <?php echo $row_Lista_fac['value']; ?></td>
     </tr>
     <tr>
       <td bgcolor="#CCCCCC">Valores de Inscripcion</td>
       <td>$ <?php echo $row_Lista_fac['values']; ?></td>
     </tr>
     <tr>
       <td bgcolor="#CCCCCC">Valores de Sancion</td>
       <td>$ <?php echo $row_Lista_fac['valores']; ?></td>
     </tr>
     <tr>
       <td bgcolor="#CCCCCC">Valores de Reconexion</td>
       <td> $ <?php echo $row_Lista_fac['valor']; ?></td>
     </tr>
     <tr>
       <td bgcolor="#CCCCCC">Total a Pagar</td>
       <td>$ <?php echo $row_Lista_fac['total_pago']; ?></td>
     </tr>
     <tr>
       <td bgcolor="#CCCCCC">Acciones</td>
       <td><a href="Facturas_edit.php?recordID=<?php echo $row_Lista_fac['id_detalle']; ?>"><img src="../images/edit.jpg" width="31" height="30"/></a> / <a href="Facturas_delet.php?recordID=<?php echo $row_Lista_fac['id_detalle']; ?>"><img src="../images/delet.jpg" width="31" height="30"/></a></td>
     </tr>
   </table>
   <?php } while ($row_Lista_fac = mysql_fetch_assoc($Lista_fac)); ?>
   <p>&nbsp;   
   <table border="0">
     <tr>
       <td><?php if ($pageNum_Lista_fac > 0) { // Show if not first page ?>
         <a href="<?php printf("%s?pageNum_Lista_fac=%d%s", $currentPage, 0, $queryString_Lista_fac); ?>">Primero</a>
         <?php } // Show if not first page ?></td>
       <td><?php if ($pageNum_Lista_fac > 0) { // Show if not first page ?>
         <a href="<?php printf("%s?pageNum_Lista_fac=%d%s", $currentPage, max(0, $pageNum_Lista_fac - 1), $queryString_Lista_fac); ?>">Anterior</a>
         <?php } // Show if not first page ?></td>
       <td><?php if ($pageNum_Lista_fac < $totalPages_Lista_fac) { // Show if not last page ?>
         <a href="<?php printf("%s?pageNum_Lista_fac=%d%s", $currentPage, min($totalPages_Lista_fac, $pageNum_Lista_fac + 1), $queryString_Lista_fac); ?>">Siguiente</a>
         <?php } // Show if not last page ?></td>
       <td><?php if ($pageNum_Lista_fac < $totalPages_Lista_fac) { // Show if not last page ?>
         <a href="<?php printf("%s?pageNum_Lista_fac=%d%s", $currentPage, $totalPages_Lista_fac, $queryString_Lista_fac); ?>">&Uacute;ltimo</a>
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
mysql_free_result($Lista_fac);
?>
