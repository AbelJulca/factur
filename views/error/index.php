<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="author" content="Codilans">
<!--        <meta name="description" content="Sistema de control de Venta">-->

        <title>Login | Codilans</title>
        <link rel="shortcut icon" type="image/x-icon" href="<?php echo URL ?>public/images/dashboard.ico" />

        <!-- Bootstrap Css -->
        <link href="<?php echo URL ?>public/css/bootstrap.min.css" rel="stylesheet">

        <!-- Hoja de estilos -->
        <link href="<?php echo URL ?>public/css/index.css" rel="stylesheet">

        <!-- Google fonts -->
        <link href="https://fonts.googleapis.com/css?family=Muli:400,700&display=swap" rel="stylesheet">

        <!-- Ionic icons -->
        <link href="https://unpkg.com/ionicons@4.5.10-0/dist/css/ionicons.min.css" rel="stylesheet">

    </head>
    <body>
        <div  class="d-none d-sm-block">
            <br><br>
            <br><br><br>         
        </div>

        <div class="bloque">
            <br><br><br><br>
        </div>

        <div class="container justify-content-center align-items-center h-75">
            <div class="row content justify-content-center mt-4">
                <div class="col-md-5 col-12 mt-4">
                    <div class="text-center">
                        <img src="<?php echo URL ?>public/images/logo_1.svg" class="img-fluid" >
                    </div>
                </div>
                <div class="col-md-3 col-9 align-items-center mt-4">                
                    <form id="iniciar" action="<?php echo URL ?>index/login" method="post">
                        <div class="form-group mt-4">                       
                            <input id="user" type="text" name="login" class="form-control form-codilan" placeholder="USUARIO">                        
                        </div>
                        <div class="form-group">                        
                            <input id="clave" type="password" name="password" class="form-control form-codilan" placeholder="CONTRASEÑA">                            
                        </div>
                        <div class="text-center">
                            <small id="smallIniciar" class="font-weight-bold h6">USUARIO O CLAVE ERRÓNEAS</small>
                        </div>
                        <br>                        
                        <div class="row justify-content-center">
                            <input class="btn btn-class mb-5" type="submit" value="INGRESAR">
                        </div> 
                    </form>
                </div>
            </div>
        </div>

        <!-- Bootstrap y JQuery -->
        <script src="<?php echo URL ?>public/js/jquery.js"></script>
        <script src="<?php echo URL ?>public/js/bootstrap.min.js"></script>       
    </body>

</html>