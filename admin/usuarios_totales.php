<?php require_once('../Connections/conexion.php'); ?><?php
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

$colname_DetailRS1 = "-1";
if (isset($_GET['recordID'])) {
  $colname_DetailRS1 = $_GET['recordID'];
}
mysql_select_db($database_conexion, $conexion);
$query_DetailRS1 = sprintf("SELECT usuarios.id_usuario, usuarios.nombres_apellidos, usuarios.cedula, usuarios.email, usuarios.telefono FROM usuarios WHERE id_usuario = %s ORDER BY usuarios.nombres_apellidos ASC", GetSQLValueString($colname_DetailRS1, "int"));
$DetailRS1 = mysql_query($query_DetailRS1, $conexion) or die(mysql_error());
$row_DetailRS1 = mysql_fetch_assoc($DetailRS1);
$totalRows_DetailRS1 = mysql_num_rows($DetailRS1);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
</head>

<body>

<table border="1" align="center">
  <tr>
    <td>id_usuario</td>
    <td><?php echo $row_DetailRS1['id_usuario']; ?></td>
  </tr>
  <tr>
    <td>nombres_apellidos</td>
    <td><?php echo $row_DetailRS1['nombres_apellidos']; ?></td>
  </tr>
  <tr>
    <td>cedula</td>
    <td><?php echo $row_DetailRS1['cedula']; ?></td>
  </tr>
  <tr>
    <td>email</td>
    <td><?php echo $row_DetailRS1['email']; ?></td>
  </tr>
  <tr>
    <td>telefono</td>
    <td><?php echo $row_DetailRS1['telefono']; ?></td>
  </tr>
</table>
</body>
</html><?php
mysql_free_result($DetailRS1);
?>