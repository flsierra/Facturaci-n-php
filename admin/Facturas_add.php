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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO detalle_factura (fecha_pago, soporte, id_usuario, id_deuda, id_mensualidad, id_inscripcion, id_sancion, id_reconexion, total_pago) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['fecha_pago'], "date"),
                       GetSQLValueString($_POST['soporte'], "text"),
                       GetSQLValueString($_POST['id_usuario'], "int"),
                       GetSQLValueString($_POST['id_deuda'], "int"),
                       GetSQLValueString($_POST['id_mensualidad'], "int"),
                       GetSQLValueString($_POST['id_inscripcion'], "int"),
                       GetSQLValueString($_POST['id_sancion'], "int"),
                       GetSQLValueString($_POST['id_reconexion'], "int"),
                       GetSQLValueString($_POST['total_pago'], "int"));

  mysql_select_db($database_conexion, $conexion);
  $Result1 = mysql_query($insertSQL, $conexion) or die(mysql_error());

  $insertGoTo = "Facturas_lista.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

mysql_select_db($database_conexion, $conexion);
$query_Recordset1Usuarios = "SELECT * FROM usuarios WHERE usuarios.rol ='3'";
$Recordset1Usuarios = mysql_query($query_Recordset1Usuarios, $conexion) or die(mysql_error());
$row_Recordset1Usuarios = mysql_fetch_assoc($Recordset1Usuarios);
$totalRows_Recordset1Usuarios = mysql_num_rows($Recordset1Usuarios);

mysql_select_db($database_conexion, $conexion);
$query_Recordset1deuda = "SELECT * FROM deuda";
$Recordset1deuda = mysql_query($query_Recordset1deuda, $conexion) or die(mysql_error());
$row_Recordset1deuda = mysql_fetch_assoc($Recordset1deuda);
$totalRows_Recordset1deuda = mysql_num_rows($Recordset1deuda);

mysql_select_db($database_conexion, $conexion);
$query_Recordset1mensualida = "SELECT * FROM mensualidad";
$Recordset1mensualida = mysql_query($query_Recordset1mensualida, $conexion) or die(mysql_error());
$row_Recordset1mensualida = mysql_fetch_assoc($Recordset1mensualida);
$totalRows_Recordset1mensualida = mysql_num_rows($Recordset1mensualida);

mysql_select_db($database_conexion, $conexion);
$query_Recordset1inscripcion = "SELECT * FROM inscripcion";
$Recordset1inscripcion = mysql_query($query_Recordset1inscripcion, $conexion) or die(mysql_error());
$row_Recordset1inscripcion = mysql_fetch_assoc($Recordset1inscripcion);
$totalRows_Recordset1inscripcion = mysql_num_rows($Recordset1inscripcion);

mysql_select_db($database_conexion, $conexion);
$query_Recordset1sancion = "SELECT * FROM sancion";
$Recordset1sancion = mysql_query($query_Recordset1sancion, $conexion) or die(mysql_error());
$row_Recordset1sancion = mysql_fetch_assoc($Recordset1sancion);
$totalRows_Recordset1sancion = mysql_num_rows($Recordset1sancion);

mysql_select_db($database_conexion, $conexion);
$query_Recordset1reconexion = "SELECT * FROM reconexion";
$Recordset1reconexion = mysql_query($query_Recordset1reconexion, $conexion) or die(mysql_error());
$row_Recordset1reconexion = mysql_fetch_assoc($Recordset1reconexion);
$totalRows_Recordset1reconexion = mysql_num_rows($Recordset1reconexion);
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
                $("#fecha_pago").datepicker()({
                    dateFormat: "dd-mm-yy"
                });
            });
        </script>
  <script>
  function subirarchivo()
{
	self.name = 'opener';
	remote =open('gestionfactura.php', 'remote',
'width=400,heigh=150,location=no,scrollbars=yes,mnubars=no,toolbars=no,resizable=yes,fullscreen=no, status=yes')
	remote.focus();
}
  </script>

   <h1>Insertar Facturas</h1>
   <p>&nbsp;</p>
   
   <p>&nbsp;</p>
   <form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
     <table align="center">
       <tr valign="baseline">
         <td nowrap="nowrap" align="right">Fecha de Pago:</td>
         <td><input type="text" name="fecha_pago" id ="fecha_pago" value="" size="32" required=""/></td>
       </tr>
       <tr valign="baseline">
         <td nowrap="nowrap" align="right">Soporte:</td>
         <td><input type="text" name="soporte" value="" size="32" required=""/><input type="button" name="button" id="button" value="Subir Factura" onclick="javascpript:subirarchivo();"/></td>
       </tr>
       <tr valign="baseline">
         <td nowrap="nowrap" align="right">Usuario:</td>
         <td><select name="id_usuario">
           <?php 
do {  
?>
           <option value="<?php echo $row_Recordset1Usuarios['id_usuario']?>" ><?php echo $row_Recordset1Usuarios['nombres_apellidos']?></option>
           <?php
} while ($row_Recordset1Usuarios = mysql_fetch_assoc($Recordset1Usuarios));
?>
         </select></td>
       </tr>
       <tr> </tr>
       <tr valign="baseline">
         <td nowrap="nowrap" align="right">Deuda:</td>
         <td><select name="id_deuda">
           <?php 
do {  
?>
           <option value="<?php echo $row_Recordset1deuda['id_deuda']?>" ><?php echo $row_Recordset1deuda['value']?></option>
           <?php
} while ($row_Recordset1deuda = mysql_fetch_assoc($Recordset1deuda));
?>
         </select></td>
       </tr>
       <tr> </tr>
       <tr valign="baseline">
         <td nowrap="nowrap" align="right">Mensualidad:</td>
         <td><select name="id_mensualidad">
           <?php 
do {  
?>
           <option value="<?php echo $row_Recordset1mensualida['id_mensualidad']?>" ><?php echo $row_Recordset1mensualida['mes']?></option>
           <?php
} while ($row_Recordset1mensualida = mysql_fetch_assoc($Recordset1mensualida));
?>
         </select></td>
       </tr>
       <tr> </tr>
       <tr valign="baseline">
         <td nowrap="nowrap" align="right">Inscripcion:</td>
         <td><select name="id_inscripcion">
           <?php 
do {  
?>
           <option value="<?php echo $row_Recordset1inscripcion['id_inscripcion']?>" ><?php echo $row_Recordset1inscripcion['values']?></option>
           <?php
} while ($row_Recordset1inscripcion = mysql_fetch_assoc($Recordset1inscripcion));
?>
         </select></td>
       </tr>
       <tr> </tr>
       <tr valign="baseline">
         <td nowrap="nowrap" align="right">Sancion:</td>
         <td><select name="id_sancion">
           <?php 
do {  
?>
           <option value="<?php echo $row_Recordset1sancion['id_sancion']?>" ><?php echo $row_Recordset1sancion['valores']?></option>
           <?php
} while ($row_Recordset1sancion = mysql_fetch_assoc($Recordset1sancion));
?>
         </select></td>
       </tr>
       <tr> </tr>
       <tr valign="baseline">
         <td nowrap="nowrap" align="right">Reconexion:</td>
         <td><select name="id_reconexion">
           <?php 
do {  
?>
           <option value="<?php echo $row_Recordset1reconexion['id_reconexion']?>" ><?php echo $row_Recordset1reconexion['valor']?></option>
           <?php
} while ($row_Recordset1reconexion = mysql_fetch_assoc($Recordset1reconexion));
?>
         </select></td>
       </tr>
       <tr> </tr>
       <tr valign="baseline">
         <td nowrap="nowrap" align="right">Total a Pagar:</td>
         <td><input type="text" name="total_pago" value="" size="32" required=""/></td>
       </tr>
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
mysql_free_result($Recordset1Usuarios);

mysql_free_result($Recordset1deuda);

mysql_free_result($Recordset1mensualida);

mysql_free_result($Recordset1inscripcion);

mysql_free_result($Recordset1sancion);

mysql_free_result($Recordset1reconexion);
?>
