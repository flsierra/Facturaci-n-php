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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE usuarios SET nombres_apellidos=%s, cedula=%s, email=%s, telefono=%s, direccion=%s, password=%s WHERE id_usuario=%s",
                       GetSQLValueString($_POST['nombres_apellidos'], "text"),
                       GetSQLValueString($_POST['cedula'], "text"),
                       GetSQLValueString($_POST['email'], "text"),
                       GetSQLValueString($_POST['telefono'], "text"),
                       GetSQLValueString($_POST['direccion'], "text"),
                       GetSQLValueString($_POST['password'], "text"),
                       GetSQLValueString($_POST['id_usuario'], "int"));

  mysql_select_db($database_conexion, $conexion);
  $Result1 = mysql_query($updateSQL, $conexion) or die(mysql_error());

  $updateGoTo = "asociado_modificar_ok.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$varUsuario_Datos_Usuario = "0";
if (isset($_SESSION["MM_IdUsuario"])) {
  $varUsuario_Datos_Usuario = $_SESSION["MM_IdUsuario"];
}
mysql_select_db($database_conexion, $conexion);
$query_Datos_Usuario = sprintf("SELECT * FROM usuarios WHERE usuarios.id_usuario =%s", GetSQLValueString($varUsuario_Datos_Usuario, "int"));
$Datos_Usuario = mysql_query($query_Datos_Usuario, $conexion) or die(mysql_error());
$row_Datos_Usuario = mysql_fetch_assoc($Datos_Usuario);
$totalRows_Datos_Usuario = mysql_num_rows($Datos_Usuario);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/Principal.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!-- InstanceBeginEditable name="doctitle" -->
<title>Sistema de Facturacion</title>
<!-- InstanceEndEditable -->
<!-- InstanceBeginEditable name="head" -->
<script src="../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link href="../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<!-- InstanceEndEditable -->
<link href="../css/principal.css" rel="stylesheet" type="text/css" />
<link rel="shorcut icon" href="../images/logo.png"/>
</head>

<body>

<div class="container">
  <div class="header"><div class="headerinterior"></div></div>
  <div class="subcontenedor">
          <div class="sidebar1">
          <?PHP include ("../includes/catalogo.php");?>
          <!-- end .sidebar1 --></div>
          <!-- InstanceBeginEditable name="EditRegion3" -->
          <div class="content">
            <h1>Modificar Datos de Usuario</h1>
            <p>&nbsp;</p>
            <p>Modifique sus datos por favor.... Muchas Gracias..</p>
            <p>&nbsp;</p>
            <form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
              <table align="center">
                <tr valign="baseline">
                  <td nowrap="nowrap" align="right">Nombres y Apellidos:</td>
                  <td><input type="text" name="nombres_apellidos" value="<?php echo htmlentities($row_Datos_Usuario['nombres_apellidos'], ENT_COMPAT, 'utf-8'); ?>" size="32" required=""/></td>
                </tr>
                <tr valign="baseline">
                  <td nowrap="nowrap" align="right">Cedula:</td>
                  <td><input type="text" name="cedula" value="<?php echo htmlentities($row_Datos_Usuario['cedula'], ENT_COMPAT, 'utf-8'); ?>" size="32" required=""/></td>
                </tr>
                <tr valign="baseline">
                  <td nowrap="nowrap" align="right">Email:</td>
                  <td><span id="sprytextfield1">
                  <input type="text" name="email" value="<?php echo htmlentities($row_Datos_Usuario['email'], ENT_COMPAT, 'utf-8'); ?>" size="32" />
                  <span class="textfieldRequiredMsg">Se necesita un valor.</span><span class="textfieldInvalidFormatMsg">Formato no válido.</span></span></td>
                </tr>
                <tr valign="baseline">
                  <td nowrap="nowrap" align="right">Telefono:</td>
                  <td><input type="text" name="telefono" value="<?php echo htmlentities($row_Datos_Usuario['telefono'], ENT_COMPAT, 'utf-8'); ?>" size="32" required=""/></td>
                </tr>
                <tr valign="baseline">
                  <td nowrap="nowrap" align="right">Direccion:</td>
                  <td><input type="text" name="direccion" value="<?php echo htmlentities($row_Datos_Usuario['direccion'], ENT_COMPAT, 'utf-8'); ?>" size="32" required="" /></td>
                </tr>
                <tr valign="baseline">
                  <td nowrap="nowrap" align="right">Contraseña:</td>
                  <td><input type="password" name="password" value="<?php echo htmlentities($row_Datos_Usuario['password'], ENT_COMPAT, 'utf-8'); ?>" size="32" required=""/></td>
                </tr>
                <tr valign="baseline">
                  <td nowrap="nowrap" align="right">&nbsp;</td>
                  <td><input type="submit" value="Actualizar registro" /></td>
                </tr>
              </table>
              <input type="hidden" name="MM_update" value="form1" />
              <input type="hidden" name="id_usuario" value="<?php echo $row_Datos_Usuario['id_usuario']; ?>" />
            </form>
            <p>&nbsp;</p>
<p>&nbsp;</p>
            <!-- end .content -->
          </div>
          <script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "email");
          </script>
  <!-- InstanceEndEditable --><!-- end .sucontenedor --></div>
  <div class="footer">
    <center> <p><strong>Copyright  ©2019 ASOCUCAITA TV</strong></p>
   <p>ELABORADO POR: <a link href="https://www.facebook.com/PI-Technological-106580044158085/?epa=SEARCH_BOX"> PI TECHONOLOGICAL </a></p>
   </center>
    <!-- end .footer --></div>
  <!-- end .container --></div>
</body>
<!-- InstanceEnd --></html>
<?php
mysql_free_result($Datos_Usuario);
?>
