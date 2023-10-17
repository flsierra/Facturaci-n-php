<title>Sistema de Facturacion</title>
<link href="../css/estyle.css" rel="stylesheet" type="text/css" />
<link rel="shorcut icon" href="../images/logo.jpg"/>

<style type="text/css">
body p {
	font-family: Verdana, Geneva, sans-serif;
}
</style>
<center>
<form name="form1" method="post" action="Asociados_search.php" id="cdr" >
  <h1><strong>Buscar Asociado </strong></h1>
      <p>
        <input name="busca"  type="text" id="busqueda" placeholder="Nombre" required=""><br /><br />
        <input type="submit" name="Submit" value="Buscar Asociado" />
  </p>
      </p>
  <p><a href="Asociados_lista.php">Lista de Asociados</a></p>
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
$busqueda=mysql_query("SELECT id_usuario,nombres_apellidos,cedula,email,telefono,direccion FROM usuarios WHERE rol='3' and nombres_apellidos LIKE '%".$busca."%'");//cambiar nombre de la tabla de busqueda
?>
<table width="100%" border="1" id="tab">
   <tr>
     <td width="19" bgcolor="#00FFFF"><strong>Nombres y Apellidos </strong></td>
     <td width="61" bgcolor="#00FFFF"><strong>Identificación</strong></td>
     <td width="157" bgcolor="#00FFFF"><strong>Correo </strong></td>
     <td width="221" bgcolor="#00FFFF"><strong>Telefono</strong></td>
      <td width="221" bgcolor="#00FFFF"><strong>Dirección</strong></td>
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
echo '<td>'.'<a href="Asociados_edit.php?recordID='.$f['id_usuario'].'">'.'Modificar'.'</a>'.'</td>';
echo '<td>'.'<a href="Asociados_delete.php?recordID='.$f['id_usuario'].'">'.'Eliminar'.'</a>'.'</td>';




echo '</tr>';

}

}
?>

</table>