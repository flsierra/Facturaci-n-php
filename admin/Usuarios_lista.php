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

$maxRows_Lista_usu = 20;
$pageNum_Lista_usu = 0;
if (isset($_GET['pageNum_Lista_usu'])) {
  $pageNum_Lista_usu = $_GET['pageNum_Lista_usu'];
}
$startRow_Lista_usu = $pageNum_Lista_usu * $maxRows_Lista_usu;

mysql_select_db($database_conexion, $conexion);
$query_Lista_usu = "SELECT * FROM usuarios ORDER BY usuarios.nombres_apellidos ASC";
$query_limit_Lista_usu = sprintf("%s LIMIT %d, %d", $query_Lista_usu, $startRow_Lista_usu, $maxRows_Lista_usu);
$Lista_usu = mysql_query($query_limit_Lista_usu, $conexion) or die(mysql_error());
$row_Lista_usu = mysql_fetch_assoc($Lista_usu);

if (isset($_GET['totalRows_Lista_usu'])) {
  $totalRows_Lista_usu = $_GET['totalRows_Lista_usu'];
} else {
  $all_Lista_usu = mysql_query($query_Lista_usu);
  $totalRows_Lista_usu = mysql_num_rows($all_Lista_usu);
}
$totalPages_Lista_usu = ceil($totalRows_Lista_usu/$maxRows_Lista_usu)-1;
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
   <h1>Lista de Usuarios en el Sistema</h1>
   <p><a href="Usuarios_add.php">Añadir Usuario<img src="../images/add.jpg" width="50" height="60"/></a>
   <p><a href="Usuarios_search.php">Buscar Usuario</a> <a href="Usuarios_search.php"><img src="../images/search.jpg" width="50" height="60"/></a>      
   <p>   
   <table width="100%" border="1">
  <tr>
    <td width="36%" bgcolor="#CCCCCC"><em><strong>Nombres y Apellidos</strong></em></td>
    <td width="16%" bgcolor="#CCCCCC"><em><strong>Cedula</strong></em></td>
    <td width="20%" bgcolor="#CCCCCC"><em><strong>Correo</strong></em></td>
    <td width="14%" bgcolor="#CCCCCC"><em><strong>Telefono</strong></em></td>
    <td width="22%" bgcolor="#CCCCCC"><em><strong>Direccion</strong></em></td>
    <td width="2%" bgcolor="#CCCCCC"><em><strong>Rol</strong></em></td>
    <td width="15%" bgcolor="#CCCCCC"><em><strong>Acciones</strong></em></td>
  </tr>
  <?php do { ?>
  <tr>
    <td><?php echo $row_Lista_usu['nombres_apellidos']; ?></td>
    <td><?php echo $row_Lista_usu['cedula']; ?></td>
    <td><?php echo $row_Lista_usu['email']; ?></td>
    <td><?php echo $row_Lista_usu['telefono']; ?></td>
    <td><?php echo $row_Lista_usu['direccion']; ?></td>
       <td><?php echo $row_Lista_usu['rol']; ?></td>
    <td><a href="Usuarios_edit.php?recordID=<?php echo $row_Lista_usu['id_usuario']; ?>"><img src="../images/edit.jpg" width="21" height="20"/></a> / <a href="Usuarios_delet.php?recordID=<?php echo $row_Lista_usu['id_usuario']; ?>"><img src="../images/delet.jpg" width="21" height="20"/></a></td>
    
  </tr>
  <?php } while ($row_Lista_usu = mysql_fetch_assoc($Lista_usu)); ?>
   </table>
&nbsp;</p>
  
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
mysql_free_result($Lista_usu);
?>
