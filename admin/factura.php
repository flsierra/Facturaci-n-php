<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Sistema de Facturacion</title>
</head>

<body>
  <?php
        include 'config.inc.php';
        $db=new Conect_MySql();
            $sql = "select* from detalle_factura where id_detalle=".$_GET['recordID'];
            $query = $db->execute($sql);
            if($datos=$db->fetch_row($query)){
                if($datos['soporte']==""){?>
        <p>NO tiene archivos</p>
                <?php }else{ ?>
        <p><a href="Facturas_lista.php">Volver a Lista de Facturas</a></p>
        <p><a href="Facturas_search.php">Volver a Busqueda</a></p>
        <center>
<iframe src="../Docs/Facturas/<?php echo $datos['soporte']; ?>" height="500px" width="700px"></iframe></center>
                
                <?php } } ?>
</body>
</html>