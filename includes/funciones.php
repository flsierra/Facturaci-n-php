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
function ObtenerNombreUsuario($identificador)
{
	global  $database_conexion, $conexion;
	mysql_select_db($database_conexion, $conexion);
	$query_ConsultaFuncion = sprintf("SELECT nombres_apellidos FROM usuarios WHERE usuarios.id_usuario = %s", $identificador);
	$ConsultaFuncion = mysql_query($query_ConsultaFuncion, $conexion) or die(mysql_error());
	$row_ConsultaFuncion = mysql_fetch_assoc($ConsultaFuncion);
	$totalRows_ConsultaFuncion = mysql_num_rows($ConsultaFuncion);
	return $row_ConsultaFuncion['nombres_apellidos']; 
	mysql_free_result($ConsultaFuncion);
}
//*************************************
//*************************************
//*************************************
function ObtenerFacturaUsuario($identificador)
{
	global  $database_conexion, $conexion;
	mysql_select_db($database_conexion, $conexion);
	$query_ConsultaFuncion = sprintf("SELECT detalle_factura.soporte FROM detalle_factura,usuarios WHERE detalle_factura.id_usuario = usuarios.id_usuario and usuarios.id_usuario = %s ",$identificador);
	$ConsultaFuncion = mysql_query($query_ConsultaFuncion, $conexion) or die(mysql_error());
	$row_ConsultaFuncion = mysql_fetch_assoc($ConsultaFuncion);
	$totalRows_ConsultaFuncion = mysql_num_rows($ConsultaFuncion);
	return $row_ConsultaFuncion['soporte'];
	mysql_free_result($ConsultaFuncion);
 } 
?>
