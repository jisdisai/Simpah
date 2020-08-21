<?php
	include("conexion.php");
    $usuario="";
    if(isset($_POST['idUsuario'])){
    	session_start();
    	session_destroy();    	
    	$sql="UPDATE tbl_usuario SET tbl_usuario.activo=0 WHERE tbl_usuario.id=".$_POST['idUsuario'];
    	$con = new Conexion();
    	$resultado=$con->ejecutarSql($sql);
    	echo("location.href='index.php';");
    }
   
   
?>