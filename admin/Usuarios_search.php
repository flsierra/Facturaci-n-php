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
<title>Sistema de Facturacion</title>
<link rel="shorcut icon" href="../images/logo.jpg"/>

<style type="text/css">
body p {
	font-family: Verdana, Geneva, sans-serif;
}
</style>
<center>
<form name="form1" method="post" action="Usuarios_search.php" id="cdr" >
  <h1><strong>Buscar Cliente </strong></h1>
      <p>
        <input name="busca"  type="text" id="busqueda" placeholder="Nombre" required=""><br /><br />
        <input type="submit" name="Submit" value="Buscar Usuario" />
  </p>
      </p>
  <p><a href="Usuarios_lista.php">Lista de Usuarios</a></p>
</form>
</center>
 <p>
  <style type="text/css">
input{outline:none;border:0px;}
#busqueda{background:#fff;color:#000;}
#cdr{padding:5px;background:#9CC;width:220px;border-radius:10px 0px 0px 10px;}
#tab{background:#CCC;;border-radius:10px 10px 10px 10px;}
</style>
      <?php
   if (!isset($_SESSION)) {
  session_start();
} 
   ?>
  <?php
$busca="";
if(isset($_POST['busca']))
$busca=$_POST['busca'];
mysql_connect("localhost","root","");// si haces conexion desde internnet usa 3 parametros si es a nivel local solo 2
mysql_select_db("facturacion_electronica");//nombre de la base de datos
if(isset($_POST['busca']))
$busca=$_POST['busca'];
if($busca!=""){
$busqueda=mysql_query("SELECT id_usuario,nombres_apellidos,cedula,email,telefono,direccion,rol FROM usuarios WHERE  nombres_apellidos LIKE '%".$busca."%'");//cambiar nombre de la tabla de busqueda
?>
<table width="100%" border="1" id="tab">
   <tr>
     <td width="19" bgcolor="#00FFFF"><strong>Nombres y Apellidos </strong></td>
     <td width="61" bgcolor="#00FFFF"><strong>Identificación</strong></td>
     <td width="157" bgcolor="#00FFFF"><strong>Correo </strong></td>
     <td width="221" bgcolor="#00FFFF"><strong>Telefono</strong></td>
      <td width="221" bgcolor="#00FFFF"><strong>Dirección</strong></td>
      <td width="221" bgcolor="#00FFFF"><strong>Rol</strong></td>
      <td width="221" bgcolor="#00FFFF"><strong>Accion</strong></td>
      <td width="221" bgcolor="#00FFFF"><strong>Accion</strong></td>
     
   
  </tr>
 
<?php

while($f=mysql_fetch_array($busqueda)){
echo '<tr>';
echo '<td width="20">'.$f['nombres_apellidos'].'</td>';
echo '<td width="61">'.$f['cedula'].'</td>';
echo '<td width="157">'.$f['email'].'</td>';
echo '<td width="157">'.$f['telefono'].'</td>';
echo '<td width="157">'.$f['direccion'].'</td>';
echo '<td width="157">'.$f['rol'].'</td>';
echo '<td>'.'<a href="Usuarios_edit.php?recordID='.$f['id_usuario'].'">'.'Modificar'.'</a>'.'</td>';
echo '<td>'.'<a href="Usuarios_delete.php?recordID='.$f['id_usuario'].'">'.'Eliminar'.'</a>'.'</td>';




echo '</tr>';

}

}
?>

</table>