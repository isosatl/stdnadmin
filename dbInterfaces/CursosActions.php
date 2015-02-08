<?php

try {
    header("Content-Type: text/html;charset=utf-8");
    require('../DB.php');     //    $dbh = null; don't forget to close the connection!

    //Getting records (listAction)
    if ($_GET["action"] == "list") {
        if (!$result = $dbh->prepare("SELECT COUNT(*) AS Registros From cursos;")) {
            throw new Exception('Query failed: ' . mysql_error($dbh));
        }
        $result->execute();
        $row = $result->fetch(PDO::FETCH_ASSOC);
        $registros = $row['Registros'];

        //Get records from database
        if (!$result = ("SELECT * FROM cursos
                    ORDER BY " . $_GET["jtSorting"] . " LIMIT " . $_GET["jtStartIndex"] . "," . $_GET["jtPageSize"] . "")) {
            throw new Exception('Query failed: ' . mysql_error($dbh));
        }

        //Add all records to an array
        $rows = array();
        foreach ($dbh->query($result) as $row) {
            $rows[] = $row;
        }

        //Return result to jTable
        $jTableResult = array();
        $jTableResult['Result'] = "OK";
        $jTableResult['TotalRecordCount'] = $registros;
        $jTableResult['Records'] = $rows;
        print json_encode($jTableResult);
    }

    //Creating a new record (createAction)	
    else if ($_GET["action"] == "create") {
        if (!$result = $dbh->prepare("INSERT INTO cursos(nombre_d_curso, unidades_del_curso)
		VALUES('" . $_POST["nombre_d_curso"] . "'," . $_POST["unidades_del_curso"] . " );")) {
            throw new Exception('Query failed: ' . mysql_error($dbh));
        }
        $result->execute();
        //Get last inserted record (to return to jTable)
        $result = $dbh->prepare("SELECT * FROM cursos WHERE id_cursos = LAST_INSERT_ID();");
        $result->execute();
        $row = $result->fetch(PDO::FETCH_ASSOC);

        //Return result to jTable
        $jTableResult = array();
        $jTableResult['Result'] = "OK";
        $jTableResult['Record'] = $row;
        print json_encode($jTableResult);
    }
    
    //Updating a record (updateAction)
    else if ($_GET["action"] == "update") {
        if (!$result = $dbh->prepare("UPDATE cursos SET nombre_d_curso = '" . $_POST["nombre_d_curso"] .
            "', unidades_del_curso = " . $_POST["unidades_del_curso"] . " WHERE id_cursos = " . $_POST["id_cursos"] . ";")){
            throw new Exception('Query failed: ' . mysql_error($dbh));            
        }
        $result->execute();
        //Return result to jTable
        $jTableResult = array();
        $jTableResult['Result'] = "OK";
        print json_encode($jTableResult);
    }

    //Deleting a record (deleteAction)
    else if ($_GET["action"] == "delete") {
        if (!$result = $dbh->prepare("DELETE FROM cursos WHERE id_cursos = " . $_POST["id_cursos"] . " ; ")) {
            throw new Exception('Query failed: ' . mysql_error($dbh));
        }
        $result->execute();
        //Return result to jTable
        $jTableResult = array();
        $jTableResult['Result'] = "OK";
        print json_encode($jTableResult);
    }

    /* close the database connection */
    $dbh = null;
    if ($dbh) {
        var_dump($dbh, " connection still active");
    }
} catch (Exception $ex) {
    $ex->getMessage();
    print $ex;
    //Return error message
    $jTableResult = array();
    $jTableResult['Result'] = "ERROR";
    $jTableResult['Message'] = $ex->getMessage();
    print json_encode($jTableResult);
}
?>