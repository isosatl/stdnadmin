<?php

/* * * mysql hostname ** */
$hostname = 'studentadmindb.db.8867750.hostedresource.com';

/* * * mysql username ** */
$username = 'studentadmindb';

/* * * mysql password ** */
$password = 'sjFHjg86';

/* * * conectar a la base de datos** */
try {
    $dbh = new PDO("mysql:host=$hostname;dbname=studentadmindb", $username, $password);
    $dbh->query("SET NAMES 'utf8'");

    /*     * * close the database connection ** */
    //$dbh = null;
    
    /*** capturar error***/
} catch (PDOException $e) {
    echo $e->getMessage();
}
?>
