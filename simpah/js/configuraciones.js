$(document).ready(function(){
   
    $("#importar").click(function(event){
    	$("#contenido").load('tablas/importar.php');
	});

    $("#registro").click(function(event){
    	$("#contenido").load('register.html');
	});
    
});
