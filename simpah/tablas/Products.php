<?php
require '../vendor/autoload.php';
require '../class/class-conexion.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Writer\Csv;
$carpeta="files/";
opendir($carpeta);
$destino=$carpeta.$_FILES['archivo']['name'];

if (!empty($_FILES['archivo']['name'])) {
    $temp1=$_FILES['archivo']['name'];
    $extension=pathinfo($temp1, PATHINFO_EXTENSION);
    if($extension!="xlsx"){
        echo '<script language="javascript"> var mensaje = confirm("archivo no valido, debe ser extensión xlsx");
            
            
        if (mensaje) {
            window.location="../administrador.php";
        }
        else {
            window.location="../administrador.php";
        }
    
    </script>';
    
    }

    else{
    copy($_FILES['archivo']['tmp_name'],$destino);
    $ruta = $_FILES["archivo"]["name"];
    $reader=\PhpOffice\PhpSpreadsheet\IOFactory::createReader("Xlsx");
    $spreadsheet=$reader->load($carpeta.$ruta);
    $con=new Conexion();
    $sheet = $spreadsheet->getActiveSheet();
    foreach($sheet->getRowIterator() as $row){
        $contf=1;
        $fecha="";
        $separadorf="'";
        $cellIterator=$row->getCellIterator();
        $cellIterator->setIterateOnlyExistingCells(false);
        $separador="'";
        $filaI="";
        foreach($cellIterator as $cell){
            if(!is_null($cell) or $cell!=""){
                if($contf>1 and $contf<5){
                    $value=$cell->getCalculatedValue();
                    $fecha=$fecha.$separadorf.$value;
                    $separadorf="-";
                    $contf=$contf+1;
                    
                }
                else{
                $value=$cell->getCalculatedValue();
                $filaI=$filaI.$separador.$value;
                $separador="','";
                $contf=$contf+1;}
            }
            
       
        }
        $fecha=$fecha."'";
        $filaI=$filaI."'";
        $filaI=$filaI.",".$fecha;
        //echo $filaI;
            //echo $filaI;
        $sql="INSERT INTO Prueba2(d1,d2,d3,d4,d5,d6,d7,fecha)VALUES($filaI)";
        $cont=0;
       if($result=$con->ejecutarConsulta($sql)){
        $cont=$cont+1; 
       }  
    }
unlink($destino);

$proc='call data';
$con->ejecutarConsulta($proc);
$previous = $_SERVER['HTTP_REFERER'];
header('Location:'.$previous);
    }
}else{
    echo '<script language="javascript"> var mensaje = confirm("No ha seleccionada ningun archivo");
        
        
            if (mensaje) {
                window.location="../administrador.php";
            }
            else {
                window.location="../administrador.php";
            }
        
        </script>';
        
}

?>