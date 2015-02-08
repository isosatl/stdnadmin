<?php
//ob_start();

//Script para determinar si se ha iniciado sessión y si es administrador.
if (session_id() == ''){
    session_start();            
}

try {
    require('../DB.php');     //    $dbh = null; don't forget to close the connection!
    
    /** query para poblar tabla de cursos ** */
    if (isset($_GET['user_email']) && isset($_GET['pwd'])){
        $usuario = $_GET['user_email'];
        $clave = $_GET['pwd'];
        if (!$result = $dbh->prepare("SELECT * FROM usuarios WHERE id_usuario LIKE '" .$usuario. "' AND clave LIKE '" .$clave. "';")){
            throw new Exception('Query failed: ' . mysql_error($dbh));
        }
        $result->execute();
        foreach ($result as $row) {
            $token = ($row['auth_token']);
        }
        $estaRegistrado = $result->rowCount();
        $_SESSION['privilegios'] = $token;
        $_SESSION['registrado'] = $estaRegistrado;
        if ($estaRegistrado == 1){
            $_SESSION['usuario'] = $usuario;
            $_SESSION['clave'] = $clave;
            $inactivo = 600;
            $_SESSION['tiempoLimite'] = $inactivo;
            //header('Location: ../welcome.php');
            Redirect('../welcome.php', false);
            exit();
        }  else {
            $_SESSION['loginerror'] = 1;
            Redirect('../login.php', false);
            exit();
        }
    }
    //ob_end_flush();
    /* close the database connection */
    $dbh = null;
    if ($dbh) {
        var_dump($dbh, " connection still active");
    }
} catch (Exception $ex) {
    $ex->getMessage();
    print $ex;
}

function Redirect($url, $permanent = false){
    if (headers_sent() === false){
        header('Location: ' . $url, true, ($permanent === true) ? 301 : 302);
    }
    exit();
}
?>
