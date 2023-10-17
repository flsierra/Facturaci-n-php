<?php require_once('../Connections/conexion.php'); ?>

<center>
<br />
<strong>Menú</strong><br  /><br  />
<a href="../asociados/index.php">Inicio</a><br /> 
<br />
  <a href="../asociados/factura.php"><em>Factura</em></a>
</center><br />
<center>
  <a href="../asociados/Parrilla.php">Parrilla de Programación</a><br /><br />
<center>
<a href="../asociados/Contacto.php">Contactenos</a><br /> 
<br />
</center>
<?php
if ((isset($_SESSION['MM_Username'])) && ($_SESSION['MM_Username'] !=""))
{
  echo "Bienvenido (a)";?> 
  <strong>
  <?php
  echo ObtenerNombreUsuario($_SESSION['MM_IdUsuario']) ;
  ?>
  </strong>
  

  <br />
  <a href="../asociados/asociado_modificar.php" class="modificacionusuario">modificar</a> - <a href="../asociados/asociado_cerrarsesion.php"class="modificacionusuario">Cerrar Sesion</a>
  </center>
<?php
}?>