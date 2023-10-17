<title>Sistema de Facturacion</title>
<link href="../css/estyle.css" rel="stylesheet" type="text/css" />
<link rel="shorcut icon" href="../images/logo.png"/>

<style type="text/css">
body p {
	font-family: Verdana, Geneva, sans-serif;
}
</style>
<center>
<form name="form1" method="post" action="Pago_search.php" id="cdr" >
  <h1><strong>Buscar Pagos en el sistema</strong></h1>
      <p>
        <input name="busca"  type="text" id="busqueda" placeholder="Referencia de Pago" required=""><br /><br />
        <input type="submit" name="Submit" value="Buscar Pago" />
  </p>
      </p>
  <p><a href="Pago_lista.php">Lista de Pagos</a></p>
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
$busqueda=mysql_query("SELECT medio_pago.id_medio,medio_pago.oficina,medio_pago.direccion,medio_pago.fecha,detalle_factura.id_detalle,detalle_factura.total_pago
FROM medio_pago,detalle_factura
WHERE medio_pago.id_detalle = detalle_factura.id_detalle and detalle_factura.id_detalle LIKE '%".$busca."%'");//cambiar nombre de la tabla de busqueda
?>
<table width="100%" border="1" id="tab">
   <tr>
     <td width="19" bgcolor="#00FFFF"><strong>Oficina </strong></td>
     <td width="61" bgcolor="#00FFFF"><strong>Direccion</strong></td>
     <td width="157" bgcolor="#00FFFF"><strong>Fecha de Pago </strong></td>
     <td width="221" bgcolor="#00FFFF"><strong>Referencia de Pago</strong></td>
      <td width="221" bgcolor="#00FFFF"><strong>Valor a Pagar</strong></td>
      <td width="221" bgcolor="#00FFFF"><strong>Accion</strong></td>
      <td width="221" bgcolor="#00FFFF"><strong>Accion</strong></td>
     
   
  </tr>
 
<?php

while($f=mysql_fetch_array($busqueda)){
echo '<tr>';
echo '<td width="20">'.$f['oficina'].'</td>';
echo '<td width="61">'.$f['direccion'].'</td>';
echo '<td width="157">'.$f['fecha'].'</td>';
echo '<td width="157">'.$f['id_detalle'].'</td>';
echo '<td width="157">'.$f['total_pago'].'</td>';
echo '<td>'.'<a href="Pago_edit.php?recordID='.$f['id_medio'].'">'.'Modificar'.'</a>'.'</td>';
echo '<td>'.'<a href="Pago_delete.php?recordID='.$f['id_medio'].'">'.'Eliminar'.'</a>'.'</td>';




echo '</tr>';

}

}
?>

</table>