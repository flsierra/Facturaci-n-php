<title>Sistema de Facturacion</title>
<link href="../css/estyle.css" rel="stylesheet" type="text/css" />
<link rel="shorcut icon" href="../images/logo.jpg"/>

<style type="text/css">
body p {
	font-family: Verdana, Geneva, sans-serif;
}
</style>
<center>
<form name="form1" method="post" action="Egresos_search.php" id="cdr" >
  <h1><strong>Reporte de  Egresos </strong></h1>
      <p>
        <input name="busca"  type="text" id="busqueda" placeholder="Mes a mostrar" required=""><br /><br />
        <input type="submit" name="Submit" value="Generar Reporte de egresos" />
  </p>
      </p>
  <p><a href="Reportes.php">Volver a Lista de Reportes</a></p>
  <p><a href="Egresos_lista.php">Volvera a Lista de Egresos</a></p>
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
$busqueda=mysql_query("select egresos.id_egreso,mensualidad.mes, egresos.productos, egresos.cantidad, egresos.fecha, egresos.soporte, SUM(egresos.valor_total) as Total_Gastado
from egresos, mensualidad
where egresos.id_mensualidad = mensualidad.id_mensualidad and mensualidad.mes LIKE '%".$busca."%'");//cambiar nombre de la tabla de busqueda
?>
<table width="100%" border="1" id="tab">
   <tr>
     <td width="250" bgcolor="#00FFFF"><strong>Mes que registra Egreso </strong></td>
     <td width="180" bgcolor="#00FFFF"><strong>Total de Egresos</strong></td>
     <td width="160" bgcolor="#00FFFF"><strong>Productos</strong></td>
     <td width="110" bgcolor="#00FFFF"><strong>Soporte</strong></td>
     


     
   
  </tr>
 
<?php

while($f=mysql_fetch_array($busqueda)){
echo '<tr>';
echo '<td width="20">'.$f['mes'].'</td>';
echo '<td width="61">'.$f['Total_Gastado'].'</td>';
echo '<td width="61">'.$f['productos'].'</td>';
echo '<td>'.'<a href="egresos.php?recordID='.$f['id_egreso'].'">'.$f['soporte'].'</a>'.'</td>';




echo '</tr>';

}

}
?>

</table>