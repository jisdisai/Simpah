<!DOCTYPE html>
<html lang="en">

<head>

	<SCRIPT src="javaScript/jquery-3.4.1.min.js"></SCRIPT>
	

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>AgroQuery - Entrar o Registrarse</title>

  <!-- Bootstrap core CSS -->
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

  <!-- Custom fonts for this template -->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
  <link href="vendor/simple-line-icons/css/simple-line-icons.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic,700italic" rel="stylesheet" type="text/css">

  <!-- Custom styles for this template -->
  <link href="css/landing-page.min.css" rel="stylesheet">

</head>

<SCRIPT>


</SCRIPT>

<body>

  <!-- Navigation -->
  <nav class="navbar navbar-dark static-top" style="background-color: #9EC709">
    <div class="container">
      <a class="navbar-brand" href="#">AgroQuery</a>
      <a class="btn btn-success" id="btn_acceder" href="login.php">Acceder</a>
    </div>
  </nav>

  <!-- Masthead -->

  <header class="masthead text-white text-center">
    <div class="overlay"></div>
    <div class="container">     
      <div class="row" id="contenedor_registro">
        <div class="col-xl-9 mx-auto">
          <h1 class="mb-5">Sistema de Información de Mercados de Productos Agrícolas de Honduras</h1>
        </div>
        <div class="col-md-10 col-lg-8 col-xl-7 mx-auto">
          <form action="registro/index.php" method="post">
            <div class="form-row">
              <div class="col-12 col-md-9 mb-2 mb-md-0">
                <input type="text" name="correo" class="form-control form-control-lg" placeholder="Email...">
              </div>
              <div class="col-12 col-md-3">
                <button type="submit" class="btn btn-block btn-lg btn-success">¡Registrarse!</button>
              </div>
            </div>
          </form>
        </div>
      </div>
      
    </div>
  </header>

  <!-- Icons Grid -->
  <section class="features-icons bg-light text-center">
    <div class="container">
      <div class="row">
        <div class="col-lg-4">
          <div class="features-icons-item mx-auto mb-5 mb-lg-4 mb-lg-4">
            <div class="features-icons-icon d-flex">
            	<i class="far fa-list-alt mx-auto mb-2 text-success"></i>              
            </div>
            <h3>Resportes</h3>
            <p class="lead mb-0">AgroQuery organiza y presenta datos extraidos de la base de información de SIMPAH, ente gubernamental que colecciona y disemina los precios de los productos agrícolas en los principales puntos de ventas del país.</p>
          </div>
        </div>
        <div class="col-lg-4">
          <div class="features-icons-item mx-auto mb-5 mb-lg-4 mb-lg-4">
            <div class="features-icons-icon d-flex">
              <i class="fas fa-chart-line mx-auto text-success mb-2"></i>
            </div>
            <h3>Visualización de datos</h3>
            <p class="lead mb-0">AgroQuery cuenta con procesos de búsqueda, interpretación, contraste y comparación de datos que te permitirán un conocimiento en profundidad de tal forma que estos se transforman en información comprensible para el tí.</p>
          </div>
        </div>
        <div class="col-lg-4">
          <div class="features-icons-item mx-auto mb-0 mb-lg-0">
            <div class="features-icons-icon d-flex">
              <img src="img/projection-icon.png" class=" mx-auto" style="width: 100px; height: 80px"></img>

            </div>
            <h3>Proyecciones</h3>
            <p class="lead mb-0">AgroQuery pone a tu disposición una herramienta de proyección de tendencias sobre los precios de los productos agrícolas, útil para maximizar inversiones.</p>
          </div>
        </div>
      </div>
    </div>
  </section>
		


  <!-- Footer -->
  <footer class="footer bg-light">
    <div class="container">
      <div class="row">
        <div class="col-lg-6 h-100 text-center text-lg-left my-auto">
          <ul class="list-inline mb-2">
            <li class="list-inline-item">
              <a href="info/about.html">Acerca de SIMPAH</a>
            </li>
            <li class="list-inline-item">&sdot;</li>
            <li class="list-inline-item">
              <a href="info/team.html">Desarrolladores</a>
            </li>            
           </ul>
          <p class="text-muted small mb-4 mb-lg-0">&copy; AgroQuery 2020. Derechos Reservados.</p>
        </div>
        
      </div>
    </div>
  </footer>


  <!-- Bootstrap core JavaScript -->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

</body>

</html>
