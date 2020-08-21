<?php

//nos permite recepcionar una variable que si exista y que no sea null
  //  require_once("conexion.php");
    //require_once("functions.php");

    $archivo = $_FILES["archivo"]["name"];

    echo $archivo."esta en la ruta temporal: " .$archivo_copiado;
/*
    $lines = file($archivo);
    $utf8_lines = array_map('utf8_encode',$lines);

    $array = array_map('str_getcsv',$utf8_lines);

    echo $array;

    if (copy($archivo ,$archivo_guardado )) {
        echo "se copeo correctamente el archivo temporal a nuestra carpeta de trabajo <br/>";
    }else{
        echo "hubo un error <br/>";
    }*/
                                /*                                          DESDE AQUI
     @move_uploaded_file($_FILES["archivo"]["tmp_name"],$archivo);

     $linea = 0;                                                                HASTA AQUI */
//Abrimos nuestro archivo
   /* $archivo = fopen($archivo, "r");                 DESDE AQUI
    
    //Lo recorremos
    while ($data = fgetcsv ($archivo, 1000, ";")) {

        $num_campos = count($data);

        for ($i = 0; $i < $num_campos; $i++) {
           echo $data[$i];
           echo "\n";
        }

      break;
    }                                                                       HASTA AQUI*/ 

//Cerramos el archivo
    /*
    
    if (file_exists($archivo_guardado)) {
         
         $fp = fopen($archivo_guardado,"r");//abrir un archivo
         $rows = 0;
         while ($datos = fgetcsv($fp , 1000 , ";")) {
                $rows ++;
               // echo $datos[0] ." ".$datos[1] ." ".$datos[2]." ".$datos[3] ."<br/>";
            if ($rows > 1) {
                $resultado = insertar_datos($datos[0],$datos[1],$datos[2],$datos[3]);
            if($resultado){
                echo "se inserto los datos correctamnete<br/>";
            }else{
                echo "no se inserto <br/>";
            }
            }
         }

*/
//VAMO A PROBAAH

//require '../class/PHPExcel-1.8/Classes/PHPExcel/IOFactory.php';
require '../class/class-conexion.php';
$nombreArchivo='prueba.xlsx';
$objPHPExcel = PHPExcel_IOFactory::load($archivo);
$objPHPExcel->setActiveSheetIndex(0);
$rows = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow();
$con=new Conexion();
$cont=0;
echo $rows;
for($i=2;$i<=$rows;$i++){

        $a=$objPHPExcel->getActiveSheet()->getCell('A'.$i)->getValue();
        $b=$objPHPExcel->getActiveSheet()->getCell('B'.$i)->getValue();
        $c=$objPHPExcel->getActiveSheet()->getCell('C'.$i)->getValue();
        $d=$objPHPExcel->getActiveSheet()->getCell('D'.$i)->getValue();
        $e=$objPHPExcel->getActiveSheet()->getCell('E'.$i)->getValue();
        $f=$objPHPExcel->getActiveSheet()->getCell('F'.$i)->getValue();
//echo $archivo,$a, $b,$c,$d,$e,$f;
$sql="INSERT INTO Prueba(tbl_producto_id,tbl_unidadventa,moneda,mercado,origen)VALUES('$a','$b','$c','$d','$e')";
if($result=$con->ejecutarConsulta($sql)){
    $cont=$cont+1;
    
};
}
$salida='Se agregaron '.$cont.' registros';
echo $salida;

?>