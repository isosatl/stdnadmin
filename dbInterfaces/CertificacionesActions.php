<?php
try {
    header("Content-Type: text/html;charset=utf-8");
    require('../DB.php');     //    $dbh = null; don't forget to close the connection!

    /** query para poblar tabla de cursos ** */
    if ($_GET["action"] == "encabezadoCert") {
        $rows = array();
        if (!$sql = "SELECT DISTINCT ca.id_ca_cursos, c.nombre_d_curso FROM alumnos AS a
            INNER JOIN calificaciones AS ca ON ca.id_ca_alumnos = a.id_alumnos
            INNER JOIN cursos AS c ON ca.id_ca_cursos = c.id_cursos
            WHERE ca.id_ca_secciones = " . $_GET["id_secciones"] . ";") {
            throw new Exception('Query failed: ' . mysql_error($dbh));
        }
        foreach ($dbh->query($sql) as $row) {
            $rows[] = $row;
        }
    header('Content-type: text/json');
    print json_encode($rows);
    } else if ($_GET["action"] == "tablaAsignaturas") {
        $rows = array();
        if (!$sql = "SELECT DISTINCT ca.id_ca_cursos, c.nombre_d_curso FROM calificaciones AS ca
            INNER JOIN cursos AS c ON ca.id_ca_cursos = c.id_cursos 
            WHERE ca.id_ca_secciones = " . $_GET["id_secciones"] . ";") {
            throw new Exception('Query failed: ' . mysql_error($dbh));
        }
        foreach ($dbh->query($sql) as $row) {
            $rows[] = $row;
        }
    header('Content-type: text/json');
    print json_encode($rows);
    } else if ($_GET["action"] == "contar") {
        $rows = array();
        if (!$sql = "SELECT COUNT(DISTINCT id_ca_cursos)AS pensum, id_ca_unidades
            FROM calificaciones
            WHERE id_ca_secciones = " . $_GET["id_secciones"] . "
            ORDER BY id_ca_cursos ;"){
                throw new Exception('Query failed: ' . mysql_error($dbh));
        }
        foreach ($dbh->query($sql) as $row) {
            $rows[] = $row;
        }
    header('Content-type: text/json');
    print json_encode($rows);
    } else if ($_GET["action"] == "certificaciones") {
        $rows = array();
        if (!$sql = "SELECT ca.id_ca_alumnos, a.nombres_alumnos, ca.id_ca_unidades, ca.calificacion, ca.id_ca_cursos
            FROM calificaciones AS ca INNER JOIN alumnos AS a ON ca.id_ca_alumnos = a.id_alumnos
            WHERE ca.id_ca_secciones = " . $_GET["id_secciones"] . "
            ORDER BY id_ca_alumnos, id_ca_unidades, id_ca_cursos ;"){
                throw new Exception('Query failed: ' . mysql_error($dbh));
        }
        foreach ($dbh->query($sql) as $row) {
            $rows[] = $row;
        }
    header('Content-type: text/json');
    print json_encode($rows);
    }
    /* close the database connection */
    $dbh = null;
    if ($dbh) {
        var_dump($dbh, " connection still active");
    }
} catch (Exception $ex) {
    $ex->getMessage();
    print $ex;
}

?>
