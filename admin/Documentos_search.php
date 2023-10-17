<title>Sistema de Facturacion</title>
<link href="../css/estyle.css" rel="stylesheet" type="text/css" />
<link rel="shorcut icon" href="../images/logo.jpg"/>

<style type="text/css">
body p {
	font-family: Verdana, Geneva, sans-serif;
}
</style>
<center>
<form name="form1" method="post" action="Documentos_search.php" id="cdr" >
  <h1><strong>Buscar Documentos </strong></h1>
      <p>
        <input name="busca"  type="text" id="busqueda" placeholder="Descripcion" required=""><br /><br />
        <input type="submit" name="Submit" value="Buscar Documento" />
  </p>
      </p>
  <p><a href="Documentos_lista.php">Lista de Documentos</a></p>
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
$busqueda=mysql_query("SELECT id_documento,descripcion,soporte FROM documentacion WHERE  descripcion LIKE '%".$busca."%'");//cambiar nombre de la tabla de busqueda
?>
<table width="100%" border="1" id="tab">
   <tr>
     <td width="220" bgcolor="#00FFFF"><strong>Descripcion </strong></td>
     <td width="261" bgcolor="#00FFFF"><strong>Soporte</strong></td>
      <td width="21" bgcolor="#00FFFF"><strong>Accion</strong></td>
      <td width="21" bgcolor="#00FFFF"><strong>Accion</strong></td>
     
   
  </tr>
 
<?php

while($f=mysql_fetch_array($busqueda)){
echo '<tr>';
echo '<td width="20">'.$f['descripcion'].'</td>';
echo '<td>'.'<a href="documentos.php?recordID='.$f['id_documento'].'">'.$f['soporte'].'</a>'.'</td>';
echo '<td>'.'<a href="Documentos_edit.php?recordID='.$f['id_documento'].'">'.'Modificar'.'</a>'.'</td>';
echo '<td>'.'<a href="Documentos_delete.php?recordID='.$f['id_documento'].'">'.'Eliminar'.'</a>'.'</td>';




echo '</tr>';

}

}
?>

</table>