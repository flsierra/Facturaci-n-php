<?php require_once('../Connections/conexion.php'); ?>
 <?php $_SESSION['MM_Username'] = "";
    $_SESSION['MM_UserGroup'] = "";	    	  
	$_SESSION['MM_IdUsuario'] = "";
	?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/Principal.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!-- InstanceBeginEditable name="doctitle" -->
<title>Sistema de Facturacion</title>
<!-- InstanceEndEditable -->
<!-- InstanceBeginEditable name="head" -->
<!-- InstanceEndEditable -->
<link href="../css/principal.css" rel="stylesheet" type="text/css" />
<link rel="shorcut icon" href="../images/logo.png"/>
</head>

<body>

<div class="container">
  <div class="header"><div class="headerinterior"></div></div>
  <div class="subcontenedor">
          <div class="sidebar1">
          <?PHP include ("../includes/catalogo.php");?>
          <!-- end .sidebar1 --></div>
          <!-- InstanceBeginEditable name="EditRegion3" -->
          <div class="content">
            <h1>Cerrando Sesion de Usuario!!</h1>
            <p>Muchas gracias por acceder.... En un momento sera redireccionado a la pagina de inicio de sesion!!!</p>
           <?php  echo '<meta http-equiv="refresh"content="1;URL=../Login/login.php">';?>
            <p>&nbsp;</p>
            <!-- end .content -->
          </div>
          <!-- InstanceEndEditable --><!-- end .sucontenedor --></div>
  <div class="footer">
    <center> <p><strong>Copyright  ©2019 ASOCUCAITA TV</strong></p>
   <p>ELABORADO POR: <a link href="https://www.facebook.com/PI-Technological-106580044158085/?epa=SEARCH_BOX"> PI TECHONOLOGICAL </a></p>
   </center>
    <!-- end .footer --></div>
  <!-- end .container --></div>
</body>
<!-- InstanceEnd --></html>
