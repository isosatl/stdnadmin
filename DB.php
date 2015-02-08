<?php

/* * * mysql hostname ** */
$hostname = 'localhost';

/* * * mysql username ** */
$username = 'stdnadmindb';

/* * * mysql password ** */
$password = '123';

/* * * conectar a la base de datos** */
try {
    $dbh = new PDO("mysql:host=$hostname;dbname=stdnadmindb", $username, $password);
    $dbh->query("SET NAMES 'utf8'");

    /*     * * close the database connection ** */
    //$dbh = null;
    
    /*** capturar error***/
} catch (PDOException $e) {
    echo $e->getMessage();
}
?>
