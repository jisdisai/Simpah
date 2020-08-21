<?php
include_once('../class/class-conexion.php');
$conexion = new Conexion();

if(isset($_POST)){
    
    // registrar Cuenta
    
    $pass = $_POST['password'];
    //$passHash = password_hash($pass, PASSWORD_BCRYPT); //encriptar la contrasena
    
    // para verificar la contrasena  usar estopassword_verify($pass, $passHash)

    $sql = sprintf("INSERT INTO tbl_cuenta ( tbl_tipo_cuenta_id, correo_cuenta, password_cuenta) VALUES ( %s, '%s', '%s')" 
    ,(int)$_POST['plan'], $_POST['email'] , $pass);
    
    $conexion->ejecutarConsulta($sql);
    $sql1 = 'SELECT id FROM tbl_cuenta ORDER BY id DESC ';
    $consulta1 = $conexion->ejecutarConsulta($sql1);



    // Guardar el nombre de usuario
    $cuentaId =$conexion->obtenerFila($consulta1) ;
    $sql3 = sprintf("INSERT INTO tbl_usuario (nombre_usuario, tbl_cuenta_id, activo,administrador) VALUES ( '%s', '%s', '0', '1');" ,
                    $_POST['username'], $cuentaId['id']);
    
    $consulta2 = $conexion->ejecutarConsulta($sql3);    
    // pasos para la integracion
    // Guardar Tarjetas de Credito

    $fecha = new DateTime($_POST['fechaVencimiento']);
    $sql4 = sprintf("INSERT INTO tbl_tarjeta_credito ( nombre_pertenece ,numero_tarjeta, vencimiento, codigo_seguridad, cuenta_id) VALUES ( '%s', '%s', '%s', '%s', '%s')",
                    $_POST['nombreTarjeta'] , $_POST['numeroTarjeta'] ,$fecha->format('Y-m-d') ,$_POST['cvv'],$cuentaId['id']  );
    $consulta3 = $conexion->ejecutarConsulta($sql4);
    var_dump($consulta3);
    // redirigir a pagina principal 
    // Crear Variables de Sesion 
    $conexion->cerrar();
    header('location:../../login.php');
}



?>