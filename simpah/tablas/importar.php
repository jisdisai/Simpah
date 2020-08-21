<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
</head>
<body>
    
            
 <div class="container">
           <form method="POST" action="tablas/Products.php" enctype="multipart/form-data">
    <div>
      <span>Upload a File:</span>
      <input type="file" name="archivo" />
    </div>
 
    <input onclick="move()" type="submit" name="archivo" value="Upload" />
  </form>
  



<div  id= "progress-bar"class="d-flex align-items-center" style="visibility: hidden; width:500px;height:500px; margin:auto;" >
  <strong>Procesando...  </strong>
  <div class="spinner-border ml-auto" role="status" aria-hidden="true" style="width:400px;height:400px;" ></div>
</div>

            <!-- Bootstrap core JavaScript-->
  
  <script>
    function move(){
      var progressbar = document.getElementById("progress-bar");
      progressbar.style.visibility='visible';
    }
  </script>
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="js/sb-admin-2.min.js"></script>
</body>
</html>