<?php 
    session_start();
    //ob_start();
    if (!isset($_SESSION['usuario']) || (!isset($_SESSION['clave']))){
        $_SESSION['violation'] = 1;
        Redirect('login.php', FALSE);
        exit();
    } if (isset($_SESSION['timeout'])){
        $sessionTTL = time() - $_SESSION['timeout'];
        if ($sessionTTL > $_SESSION['tiempoLimite']){   
            $_SESSION['logedout'] = 1;
            Redirect('login.php', FALSE);
            //header('Location: ../login.php');
            exit();
        }
    }
    $_SESSION['timeout'] = time();
    print_r($_SESSION);
    
    include 'init.php';    
function Redirect($url, $permanent = false){
    if (headers_sent() === false){
        header('Location: ' . $url, true, ($permanent === true) ? 301 : 302);
    }
    exit();
}

//ob_end_flush();

?>

<!DOCTYPE html>
<html lang="es">
    <head>
    <title>Inicio</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />        
    <link rel="stylesheet" type="text/css" href="themes/empty/css/bootstrap.css" />
    <?php include ROOT_DIR . '/includes/nav.php';?>        
    </head>
<body>
    <div class="row" style="margin-top: 185px;">
        <div class="span8 offset2">
            <div class="hero-unit">
                <p>Bienvenidos al INED Arnoldo Medrano</p>                
            </div>
        </div>
    </div>
</body>
</html>