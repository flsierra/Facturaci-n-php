<?php require_once('../Connections/conexion.php'); ?>
 <?php $_SESSION['MM_Username'] = "";
    $_SESSION['MM_UserGroup'] = "";	    	  
	$_SESSION['MM_IdUsuario'] = "";
	?>
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
.content { margin-right: -1px; } /* este margen negativo de 1 px puede situarse en cualquiera de las columnas de este dise�o con el mismo efecto corrector. */
ul.nav a { zoom: 1; }  /* la propiedad de zoom da a IE el desencadenante hasLayout que necesita para corregir el espacio en blanco extra existente entre los v�nculos */
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
   <h1>Cerrando la Sesion de Usuario</h1>
   <p>Muchas gracias por acceder!!! en un momento sera redireccionado a la pagina de inicio de sesion!!</p>
           <?php  echo '<meta http-equiv="refresh"content="2;URL=../Login/login_admin.php">';?>
  
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
