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
   <h1>Lista de Reportes</h1>
   <p>Seleccione el reporte que necesita !!!</p>
   <table width="100%" border="1">
     <tr>
       <td width="48%" bgcolor="#CCCCCC"><strong>Informes</strong></td>
       <td width="52%" bgcolor="#CCCCCC"><strong>Vinculo</strong></td>
     </tr>
     <tr>
       <td>Listado de Asociados</td>
       <td><a href="Asociados_regs.php"><img src="../images/ver.png" width="50" height="45" /></a></td>
     </tr>
     <tr>
       <td>Ingresos </td>
       <td><a href="Ingresos.php"><img src="../images/ver.png" width="50" height="45" /></a></td>
     </tr>
     <tr>
       <td>Egresos</td>
       <td><a href="Egresos_search.php"><img src="../images/ver.png" width="50" height="45" /></a></td>
     </tr>
     <tr>
       <td>Asociados en Deuda</td>
       <td><a href="Asociados_moro.php"><img src="../images/ver.png" width="50" height="45" /></a></td>
     </tr>
     <tr>
       <td>Asociados al Día</td>
       <td><a href="Asociados_ok.php"><img src="../images/ver.png" width="50" height="45" /></a></td>
     </tr>
     <tr>
       <td>Todos los Usuarios Registrados</td>
       <td><a href="Total_usu.php"><img src="../images/ver.png" width="50" height="45" /></a></td>
     </tr>
   </table>
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
