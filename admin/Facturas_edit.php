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

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE detalle_factura SET fecha_pago=%s, soporte=%s, id_usuario=%s, id_deuda=%s, id_mensualidad=%s, id_inscripcion=%s, id_sancion=%s, id_reconexion=%s, total_pago=%s WHERE id_detalle=%s",
                       GetSQLValueString($_POST['fecha_pago'], "date"),
                       GetSQLValueString($_POST['soporte'], "text"),
                       GetSQLValueString($_POST['id_usuario'], "int"),
                       GetSQLValueString($_POST['id_deuda'], "int"),
                       GetSQLValueString($_POST['id_mensualidad'], "int"),
                       GetSQLValueString($_POST['id_inscripcion'], "int"),
                       GetSQLValueString($_POST['id_sancion'], "int"),
                       GetSQLValueString($_POST['id_reconexion'], "int"),
                       GetSQLValueString($_POST['total_pago'], "int"),
                       GetSQLValueString($_POST['id_detalle'], "int"));

  mysql_select_db($database_conexion, $conexion);
  $Result1 = mysql_query($updateSQL, $conexion) or die(mysql_error());

  $updateGoTo = "Facturas_lista.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$varFact_Facturas_edit = "0";
if (isset($_GET["recordID"])) {
  $varFact_Facturas_edit = $_GET["recordID"];
}
mysql_select_db($database_conexion, $conexion);
$query_Facturas_edit = sprintf("SELECT * FROM detalle_factura WHERE detalle_factura.id_detalle =%s", GetSQLValueString($varFact_Facturas_edit, "int"));
$Facturas_edit = mysql_query($query_Facturas_edit, $conexion) or die(mysql_error());
$row_Facturas_edit = mysql_fetch_assoc($Facturas_edit);
$totalRows_Facturas_edit = mysql_num_rows($Facturas_edit);

mysql_select_db($database_conexion, $conexion);
$query_RecordsetUsuario = "SELECT * FROM usuarios WHERE usuarios.rol = '3'";
$RecordsetUsuario = mysql_query($query_RecordsetUsuario, $conexion) or die(mysql_error());
$row_RecordsetUsuario = mysql_fetch_assoc($RecordsetUsuario);
$totalRows_RecordsetUsuario = mysql_num_rows($RecordsetUsuario);

mysql_select_db($database_conexion, $conexion);
$query_RecordsetDeuda = "SELECT * FROM deuda";
$RecordsetDeuda = mysql_query($query_RecordsetDeuda, $conexion) or die(mysql_error());
$row_RecordsetDeuda = mysql_fetch_assoc($RecordsetDeuda);
$totalRows_RecordsetDeuda = mysql_num_rows($RecordsetDeuda);

mysql_select_db($database_conexion, $conexion);
$query_RecordsetMensualidad = "SELECT * FROM mensualidad";
$RecordsetMensualidad = mysql_query($query_RecordsetMensualidad, $conexion) or die(mysql_error());
$row_RecordsetMensualidad = mysql_fetch_assoc($RecordsetMensualidad);
$totalRows_RecordsetMensualidad = mysql_num_rows($RecordsetMensualidad);

mysql_select_db($database_conexion, $conexion);
$query_RecordsetInscrip = "SELECT * FROM inscripcion";
$RecordsetInscrip = mysql_query($query_RecordsetInscrip, $conexion) or die(mysql_error());
$row_RecordsetInscrip = mysql_fetch_assoc($RecordsetInscrip);
$totalRows_RecordsetInscrip = mysql_num_rows($RecordsetInscrip);

mysql_select_db($database_conexion, $conexion);
$query_RecordsetSancion = "SELECT * FROM sancion";
$RecordsetSancion = mysql_query($query_RecordsetSancion, $conexion) or die(mysql_error());
$row_RecordsetSancion = mysql_fetch_assoc($RecordsetSancion);
$totalRows_RecordsetSancion = mysql_num_rows($RecordsetSancion);

mysql_select_db($database_conexion, $conexion);
$query_RecordsetRecon = "SELECT * FROM reconexion";
$RecordsetRecon = mysql_query($query_RecordsetRecon, $conexion) or die(mysql_error());
$row_RecordsetRecon = mysql_fetch_assoc($RecordsetRecon);
$totalRows_RecordsetRecon = mysql_num_rows($RecordsetRecon);
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
  
   <h1>Editar Facturas</h1>
   <p>&nbsp;</p>
   <p>&nbsp;</p>
   <form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
     <table align="center">
       <tr valign="baseline">
         <td width="137" align="right" nowrap="nowrap">Fecha de Pago:</td>
         <td width="209"><input type="text" name="fecha_pago" id="fecha_pago" value="<?php echo htmlentities($row_Facturas_edit['fecha_pago'], ENT_COMPAT, 'utf-8'); ?>" size="32" required=""/></td>
       </tr>
       <tr valign="baseline">
         <td nowrap="nowrap" align="right">Soporte:</td>
         <td><input type="text" name="soporte" value="<?php echo htmlentities($row_Facturas_edit['soporte'], ENT_COMPAT, 'utf-8'); ?>" size="32" required=""/>
          <input type="button" name="button" id="button" value="Subir Factura" onclick="javascpript:subirarchivo();"/></td>
       </tr>
       <tr valign="baseline">
         <td nowrap="nowrap" align="right">Usuario:</td>
         <td><select name="id_usuario">
           <?php 
do {  
?>
           <option value="<?php echo $row_RecordsetUsuario['id_usuario']?>" <?php if (!(strcmp($row_RecordsetUsuario['id_usuario'], htmlentities($row_Facturas_edit['id_usuario'], ENT_COMPAT, 'utf-8')))) {echo "SELECTED";} ?>><?php echo $row_RecordsetUsuario['nombres_apellidos']?></option>
           <?php
} while ($row_RecordsetUsuario = mysql_fetch_assoc($RecordsetUsuario));
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
           <option value="<?php echo $row_RecordsetDeuda['id_deuda']?>" <?php if (!(strcmp($row_RecordsetDeuda['id_deuda'], htmlentities($row_Facturas_edit['id_deuda'], ENT_COMPAT, 'utf-8')))) {echo "SELECTED";} ?>><?php echo $row_RecordsetDeuda['value']?></option>
           <?php
} while ($row_RecordsetDeuda = mysql_fetch_assoc($RecordsetDeuda));
?>
         </select></td>
       </tr>
       <tr> </tr>
       <tr valign="baseline">
         <td nowrap="nowrap" align="right">Mes a Facturar:</td>
         <td><select name="id_mensualidad">
           <?php 
do {  
?>
           <option value="<?php echo $row_RecordsetMensualidad['id_mensualidad']?>" <?php if (!(strcmp($row_RecordsetMensualidad['id_mensualidad'], htmlentities($row_Facturas_edit['id_mensualidad'], ENT_COMPAT, 'utf-8')))) {echo "SELECTED";} ?>><?php echo $row_RecordsetMensualidad['mes']?></option>
           <?php
} while ($row_RecordsetMensualidad = mysql_fetch_assoc($RecordsetMensualidad));
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
           <option value="<?php echo $row_RecordsetInscrip['id_inscripcion']?>" <?php if (!(strcmp($row_RecordsetInscrip['id_inscripcion'], htmlentities($row_Facturas_edit['id_inscripcion'], ENT_COMPAT, 'utf-8')))) {echo "SELECTED";} ?>><?php echo $row_RecordsetInscrip['values']?></option>
           <?php
} while ($row_RecordsetInscrip = mysql_fetch_assoc($RecordsetInscrip));
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
           <option value="<?php echo $row_RecordsetSancion['id_sancion']?>" <?php if (!(strcmp($row_RecordsetSancion['id_sancion'], htmlentities($row_Facturas_edit['id_sancion'], ENT_COMPAT, 'utf-8')))) {echo "SELECTED";} ?>><?php echo $row_RecordsetSancion['valores']?></option>
           <?php
} while ($row_RecordsetSancion = mysql_fetch_assoc($RecordsetSancion));
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
           <option value="<?php echo $row_RecordsetRecon['id_reconexion']?>" <?php if (!(strcmp($row_RecordsetRecon['id_reconexion'], htmlentities($row_Facturas_edit['id_reconexion'], ENT_COMPAT, 'utf-8')))) {echo "SELECTED";} ?>><?php echo $row_RecordsetRecon['valor']?></option>
           <?php
} while ($row_RecordsetRecon = mysql_fetch_assoc($RecordsetRecon));
?>
         </select></td>
       </tr>
       <tr> </tr>
       <tr valign="baseline">
         <td nowrap="nowrap" align="right">Total a Pagar:</td>
         <td><input type="text" name="total_pago" value="<?php echo htmlentities($row_Facturas_edit['total_pago'], ENT_COMPAT, 'utf-8'); ?>" size="32" required=""/></td>
       </tr>
       <tr valign="baseline">
         <td nowrap="nowrap" align="right">&nbsp;</td>
         <td><input type="submit" value="Actualizar registro" /></td>
       </tr>
     </table>
     <input type="hidden" name="MM_update" value="form1" />
     <input type="hidden" name="id_detalle" value="<?php echo $row_Facturas_edit['id_detalle']; ?>" />
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
mysql_free_result($Facturas_edit);

mysql_free_result($RecordsetUsuario);

mysql_free_result($RecordsetDeuda);

mysql_free_result($RecordsetMensualidad);

mysql_free_result($RecordsetInscrip);

mysql_free_result($RecordsetSancion);

mysql_free_result($RecordsetRecon);
?>
