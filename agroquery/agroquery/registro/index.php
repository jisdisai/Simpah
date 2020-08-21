<?php
    include_once('class/class-conexion.php');
    $conexion = new Conexion();
    $correo="";
    if(isset($_POST['correo'])){
        $correo=$_POST['correo'];
    }
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="author" content="INDUSTRIA DEL SW- UNAH">

    <title>SIMPAH-Registro</title>


    <!-- Include SmartWizard CSS -->
    <link href="css/demo.css" rel="stylesheet" type="text/css" />

    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <!-- Include SmartWizard CSS -->
    <link href="dist/css/smart_wizard.min.css" rel="stylesheet" type="text/css" />

    <!-- Optional SmartWizard theme -->
    <link href="dist/css/smart_wizard_theme_circles.min.css" rel="stylesheet" type="text/css" />
    <link href="dist/css/smart_wizard_theme_arrows.min.css" rel="stylesheet" type="text/css" />
    <link href="dist/css/smart_wizard_theme_dots.min.css" rel="stylesheet" type="text/css" />
    <SCRIPT src="../javaScript/jquery-3.4.1.min.js"></SCRIPT>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <!-- <script async src="https://www.googletagmanager.com/gtag/js?id=UA-18629864-3"></script> -->
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'UA-18629864-3');
    </script>
    
    <!-- Google Ads -->
    <!-- <script data-ad-client="ca-pub-8226185437441708" async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script> -->
</head>
    <SCRIPT>
        $(document).ready(function(){
            $("#email").val('<?php echo($correo)?>');
        });
    </SCRIPT>
<body>
    <header>
        <nav class="navbar navbar-dark" style="background-color: #9EC709">
            <a class="navbar-brand" href="#">AgroQuery</a>
        </nav>
    </header>

    <div class="container">
        <br />
        <form action="controller/procesar.php" id="myForm" role="form" data-toggle="validator" method="post" accept-charset="utf-8">

            <!-- SmartWizard html -->
            <div id="smartwizard">
                <ul>
                    <li><a href="#step-1">Paso 1<br /><small>Datos de Acceso</small></a></li>
                    <li><a href="#step-2">Paso 2<br /><small>Plan</small></a></li>
                    <li><a href="#step-3">Paso 3<br /><small>Tarjeta de Credito</small></a></li>
                    <li><a href="#step-4">Paso 4<br /><small>Crear Primer Usuario</small></a></li>
                </ul>

                <div>
                    <div id="step-1">
                        <h2>Datos de acceso de la cuenta</h2>
                        <div id="form-step-0" role="form" data-toggle="validator">
                            <div class="form-group ">
                                <label for="email" class="control-label">Correo Electronico:</label>
                                <input type="email" class="form-control control-label" name="email" id="email" placeholder="Escribe tu correo Electronico" required>
                                <!-- <div class="help-block">Correo no Valido</div> -->
                                <div class="help-block with-errors"> </div>

                            </div>
                            <div class="form-group">
                                <label for="Password">Contraseña:</label>
                                <input type="password" class="form-control" data-minlength="8" data-error="Por favor escriba una Contraseña mayor a 8 letras" name="password" id="password" placeholder="Escribe tu Contraseña" required>
                                <div class="help-block with-errors"></div>
                            </div>
                            <div class="form-group">
                                <label for="Password">Confirme Contraseña:</label>
                                <input type="password" class="form-control" data-minlength="8" data-match="#password" data-error="Las Contraseñas no coinciden" name="comfirm" id="comfirm" placeholder="Confirma tu Contraseña" required>
                                <div class="help-block with-errors"></div>
                            </div>

                        </div>

                    </div>
                    <div id="step-2">
                        <h2>Plan de Suscripcion</h2>
                        <div id="form-step-1" role="form" data-toggle="validator">
                            <div class="form-group">
                                <!-- <label for="name">Name:</label>
                                <input type="text" class="form-control" name="name" id="email" placeholder="Write your name" required> -->
                                <div class="container">
                                    <div class="row">
                                        <?php
                                        $sql = 'SELECT id , nombre_tipo_cuenta,  cantidad_usuarios, precio_usd FROM tbl_tipo_cuenta';
                                        $resultado = $conexion->ejecutarConsulta($sql);
                                        ?>

                                        <?php
                                        while( $fila = $conexion->obtenerFila($resultado)){
                                        ?>
                                        <div class="col-sm-4 col-xs-12 offset-md-1.5 mt-2 ">
                                            <label><input type="radio" name="plan" id="plan" value="<?php echo $fila['id']?>" required> <?php echo $fila['nombre_tipo_cuenta'] ?>
                                         </label>
                                            <div class="card mt-5 plan ">
                                                <div class="card-header text-center ">
                                                   <?php echo $fila['nombre_tipo_cuenta'] ?>
                                                </div>
                                                <div class="card-body text-center">
                                                    <P class="card-text"> <?php echo $fila['cantidad_usuarios'] ?> usuarios </P>
                                                    <P class="card-text">
                                                        <small class="text-muted">USD <?php echo $fila['precio_usd'] ?></small>
                                                    </P>
                                                </div>
                                            </div>
                                        </div>
                                        <?php }
                                        $conexion->cerrar();
                                        ?>
                                       

                                      


                                    </div>
                                </div>

                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                    </div>
                    <div id="step-3">
                        <div class="border-bottom border-gray pb-2 pl-5">
                            <h3>Configura tu tarjeta de crédito o débito</h3>
                            <div class="mt-1">
                                <img src="imagenes/bac.jpg" style="width: 40px; height: 20px"></img>
                                <img src="imagenes/visa.png" style="width: 40px; height: 20px" class="pl-1"></img>
                                <img src="imagenes/american.png" style="width: 40px; height: 20px" class="pl-1"></i>
                            </div>
                        </div>
                        <div id="form-step-2" role="form" data-toggle="validator">



                            <div class="form-group">
                                <label for="nombreTarjeta">Nombre que Aparece en la Tarjeta:</label>
                                <input class="form-control form-control" type="text" name="nombreTarjeta" id="nombreTarjeta" placeholder="Nombre que aparece en la tarjeta" required>
                                <div class="help-block with-errors"></div>
                            </div>

                            <div class="form-group">
                                <label for="numeroTarjeta">Número de la Tarjeta: </label>
                                <input class="form-control form-control" type="text" name="numeroTarjeta" pattern="^(?:4[0-9]{12}(?:[0-9]{3})?|5[1-5][0-9]{14}|3[47][0-9]{13}|6(?:011|5[0-9][0-9])[0-9]{12})$" id="numeroTarjeta" data-minlength="16" data-error="Por favor ingrese una tarjeta valida" placeholder="numero de la tarjeta" required>
                                <div class="help-block with-errors"></div>
                            </div>

                            <div class="form-group">
                                <label for="fechaVencimiento">Fecha de Vencimiento: </label>
                                <input class="form-control form-control" type="date" name="fechaVencimiento" id="fechaVencimiento" data-error="Por favor ingrese una fecha valida" placeholder="Fecha de Vencimiento" required>
                                <div class="help-block with-errors"></div>
                            </div>

                            <div class="form-group">
                                <label for="fechaVencimiento">Codigo de Seguridad: </label>
                                <input class="form-control form-control" type="text" name="cvv" id="cvv" data-minlength="3" data-error="Codigo invalido" placeholder="CVV" required>
                                <div class="help-block with-errors"></div>
                            </div>

                        </div>
                    </div>
                    <div id="step-4" role="form" data-toggle="validator">
                        <h2>Cree su Nombre de Usuario</h2>
                        <p>
                            Este usuario sera administrador de su cuenta
                        </p>
                        <div id="form-step-3" role="form" data-toggle="validator">
                            <div class="form-group">
                                <label for="terms">Nombre de Usuario</label>
                                <input type="text" class="form-control" name="username" id="username" required>
                                <input type="hidden" name="rol" value="1">
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                        <!-- <div class="form-group">
                          <button type="submit" class="btn btn-primary">Registrar Usuario</button>
                        </div> -->


                    </div>
                </div>
            </div>

        </form>

    </div>

    <!-- Include jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <!-- Include jQuery Validator plugin -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/1000hz-bootstrap-validator/0.11.5/validator.min.js"></script>


    <!-- Include SmartWizard JavaScript source -->
    <script type="text/javascript" src="dist/js/jquery.smartWizard.min.js"></script>

    <script type="text/javascript">
        $(document).ready(function() {

            // Toolbar extra buttons
            var btnFinish = $('<button></button>').text('Registrar')
                .addClass('btn btn-info')
                .on('click', function() {
                    if (!$(this).hasClass('disabled')) {
                        var elmForm = $("#myForm");
                        if (elmForm) {
                            elmForm.validator('validate');
                            var elmErr = elmForm.find('.has-error');
                            if (elmErr && elmErr.length > 0) {
                                alert('Todavia hay campos imcompletos');
                                return false;
                            } else {
                                // alert('Listo usuario Registrado');
                                elmForm.submit();
                                return false;
                            }
                        }
                    }
                });
            var btnCancel = $('<button></button>').text('Cancelar')
                .addClass('btn btn-danger')
                .on('click', function() {
                   location.href='../index.php';;
                });



            // Smart Wizard
            $('#smartwizard').smartWizard({
                selected: 0,
                theme: 'dots',
                transitionEffect: 'slide',
                toolbarSettings: {
                    toolbarPosition: 'bottom',
                    toolbarExtraButtons: [btnFinish, btnCancel]
                },
                anchorSettings: {
                    markDoneStep: true, // add done css
                    markAllPreviousStepsAsDone: true, // When a step selected by url hash, all previous steps are marked done
                    removeDoneStepOnNavigateBack: true, // While navigate back done step after active step will be cleared
                    enableAnchorOnDoneStep: true // Enable/Disable the done steps navigation
                }
            });

            $("#smartwizard").on("leaveStep", function(e, anchorObject, stepNumber, stepDirection) {
                var elmForm = $("#form-step-" + stepNumber);
                // console.log(elmForm);
                // stepDirection === 'forward' :- this condition allows to do the form validation
                // only on forward navigation, that makes easy navigation on backwards still do the validation when going next
                if (stepDirection === 'forward' && elmForm) {
                    elmForm.validator('validate');
                    var elmErr = elmForm.children('.has-error');
                    console.log(elmErr);
                    if (elmErr && elmErr.length > 0) {
                        // Form validation failed
                        return false;
                    }
                }
                return true;
            });

            $("#smartwizard").on("showStep", function(e, anchorObject, stepNumber, stepDirection) {
                // Enable finish button only on last step
                if (stepNumber == 3) {
                    $('.btn-finish').removeClass('disabled');
                } else {
                    $('.btn-finish').addClass('disabled');
                }
            });

        });
    </script>
</body>

</html>