<?php require_once('../Connections/conexion.php'); ?>
<br/>
<center>
  <strong>Administracion</strong><br/><br />
  <a href="../admin/Usuarios_lista.php">Lista de Usuarios</a><br /><br />
  <a href="../admin/Asociados_lista.php"> Lista de Asociados</a><br /><br />
  <a href="../admin/Facturas_lista.php">Listado de Facturas<br /></a><br />
  <a href="../admin/Pago_lista.php"> Realizar Pagos en el sistema</a> <br /><br />
  <a href="../admin/Reportes.php"> Reportes</a><br /><br />
  <a href="../admin/Documentos_lista.php"> Listado de Documentacion Empresarial</a> <br /><br />
  <a href="../admin/Egresos_lista.php"> Listado general de Egresos</a> <br />
  <br /><br />
<?php
if ((isset($_SESSION['MM_Username'])) && ($_SESSION['MM_Username'] !=""))
{
  echo "Bienvenido (A)";?>
  <br/>
  <strong>
  <?php
  echo ObtenerNombreUsuario($_SESSION['MM_IdUsuario']) ;
}?>
  </strong> <br />
<a href="../admin/Usuario_modificar.php" class="modificacionusuario">modificar</a>- <a href="../admin/usuario_cerrarsesion.php" class="modificacionusuario">cerrar sesion</a>
</center>