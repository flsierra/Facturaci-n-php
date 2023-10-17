<?php require_once('../Connections/conexion.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "1,2";
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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO medio_pago (oficina, direccion, fecha, id_detalle) VALUES (%s, %s, %s, %s)",
                       GetSQLValueString($_POST['oficina'], "text"),
                       GetSQLValueString($_POST['direccion'], "text"),
                       GetSQLValueString($_POST['fecha'], "date"),
                       GetSQLValueString($_POST['id_detalle'], "int"));

  mysql_select_db($database_conexion, $conexion);
  $Result1 = mysql_query($insertSQL, $conexion) or die(mysql_error());

  $insertGoTo = "Pago_lista.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

mysql_select_db($database_conexion, $conexion);
$query_Recordset1Detalle = "SELECT * FROM detalle_factura";
$Recordset1Detalle = mysql_query($query_Recordset1Detalle, $conexion) or die(mysql_error());
$row_Recordset1Detalle = mysql_fetch_assoc($Recordset1Detalle);
$totalRows_Recordset1Detalle = mysql_num_rows($Recordset1Detalle);

mysql_select_db($database_conexion, $conexion);
$query_Recordset1Ofc = "SELECT * FROM medio_pago";
$Recordset1Ofc = mysql_query($query_Recordset1Ofc, $conexion) or die(mysql_error());
$row_Recordset1Ofc = mysql_fetch_assoc($Recordset1Ofc);
$totalRows_Recordset1Ofc = mysql_num_rows($Recordset1Ofc);

mysql_select_db($database_conexion, $conexion);
$query_Recordset1Dir = "SELECT * FROM medio_pago";
$Recordset1Dir = mysql_query($query_Recordset1Dir, $conexion) or die(mysql_error());
$row_Recordset1Dir = mysql_fetch_assoc($Recordset1Dir);
$totalRows_Recordset1Dir = mysql_num_rows($Recordset1Dir);
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
  <link href="../css/jquery-ui.min.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../js/jquery-3.2.1.min.js"></script>
<script type="text/javascript" src="../js/jquery-ui.js"></script>
 <script>
            $(function () {
                $("#fecha").datepicker()({
                    dateFormat: "dd-mm-yy"				
                });
            });
        </script>
   <h1>Realizar Nuevo Pago</h1>
   <p>&nbsp;</p>
   <form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
     <table align="center">
       <tr valign="baseline">
         <td nowrap="nowrap" align="right">Oficina:</td>
         <td><select name="oficina">
           <?php 
do {  
?>
           <option value="<?php echo $row_Recordset1Ofc['oficina']?>" ><?php echo $row_Recordset1Ofc['oficina']?></option>
           <?php
} while ($row_Recordset1Ofc = mysql_fetch_assoc($Recordset1Ofc));
?>
         </select></td>
       </tr>
       <tr> </tr>
       <tr valign="baseline">
         <td nowrap="nowrap" align="right">Direccion:</td>
         <td><select name="direccion">
           <?php 
do {  
?>
           <option value="<?php echo $row_Recordset1Dir['direccion']?>" ><?php echo $row_Recordset1Dir['direccion']?></option>
           <?php
} while ($row_Recordset1Dir = mysql_fetch_assoc($Recordset1Dir));
?>
         </select></td>
       </tr>
       <tr> </tr>
       <tr valign="baseline">
         <td nowrap="nowrap" align="right">Fecha:</td>
         <td><input type="text" name="fecha" id="fecha" value="" size="32" /></td>
       </tr>
       <tr valign="baseline">
         <td nowrap="nowrap" align="right">Referencia de Pago</td>
         <td><select name="id_detalle">
           <?php 
do {  
?>
           <option value="<?php echo $row_Recordset1Detalle['id_detalle']?>" ><?php echo $row_Recordset1Detalle['id_detalle']?></option>
           <?php
} while ($row_Recordset1Detalle = mysql_fetch_assoc($Recordset1Detalle));
?>
         </select></td>
       </tr>
       <tr> </tr>
       <tr valign="baseline">
         <td nowrap="nowrap" align="right">&nbsp;</td>
         <td><input type="submit" value="Insertar registro" /></td>
       </tr>
     </table>
     <input type="hidden" name="MM_insert" value="form1" />
   </form>
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
mysql_free_result($Recordset1Detalle);

mysql_free_result($Recordset1Ofc);

mysql_free_result($Recordset1Dir);
?>
