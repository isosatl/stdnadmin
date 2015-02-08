<?php
    header("Content-Type: text/html;charset=utf-8");

    $pag = basename($_SERVER['QUERY_STRING']);
    require_once 'init.php';
    if (!$pag) {
        include('login.php');
    } else {
        if (file_exists('pages/' . $pag . '.php')) {
            include ('pages/' . $pag . '.php');
        } elseif (file_exists('informes/' . $pag . '.php')) {
            include ('informes/' . $pag . '.php');
        } elseif (file_exists('imports/' . $pag . '.php')) {
            include ('imports/' . $pag . '.php');            
        } else {
            echo ('¡Esta página no existe');
        }
    }
?>
