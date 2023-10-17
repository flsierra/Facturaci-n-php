<title>Sistema de Facturacion</title>
<link rel="shorcut icon" href="../images/logo.jpg"/>

<style type="text/css">
body p {
	font-family: Verdana, Geneva, sans-serif;
}
</style>
<center>
<form name="form1" method="post" action="Ingresos.php" id="cdr" >
  <h1><strong>Reporte de  Ingresos </strong></h1>
      <p>
        <input name="busca"  type="text" id="busqueda" placeholder="Mes a mostrar" required=""><br /><br />
        <input type="submit" name="Submit" value="Generar Reporte de ingresos" />
  </p>
      </p>
  <p><a href="Reportes.php">Volver a Lista de Reportes</a></p>
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
$busqueda=mysql_query("SELECT SUM(detalle_factura.total_pago) as Total_Ingresos, mensualidad.mes
from detalle_factura, mensualidad
where detalle_factura.id_mensualidad = mensualidad.id_mensualidad and mensualidad.mes LIKE '%".$busca."%'");//cambiar nombre de la tabla de busqueda
?>
<table width="100%" border="1" id="tab">
   <tr>
     <td width="178" bgcolor="#00FFFF"><strong>Mes que registra ingresos </strong></td>
     <td width="161" bgcolor="#00FFFF"><strong>Total de Ingresos</strong></td>


     
   
  </tr>
 
<?php

while($f=mysql_fetch_array($busqueda)){
echo '<tr>';
echo '<td width="20">'.$f['mes'].'</td>';
echo '<td width="61">'.$f['Total_Ingresos'].'</td>';





echo '</tr>';

}

}
?>

</table>