<?php
try{
    header("Content-Type: text/html;charset=utf-8");
    require('../DB.php');     //    $dbh = null; don't forget to close the connection!

    /** query para poblar listBox de secciones ***/
    if ($_GET["action"] == "fillseccBox") {
        $rows = array();
        $sql = "SELECT id_secciones, nombre_d_seccion FROM secciones";
        foreach ($dbh->query($sql) as $row) {
            $rows[] = $row;
        }
        header('Content-type: text/json');
        print json_encode($rows);
    }

    /*** query para poblar listBox de carreras ***/
    else if ($_GET["action"] == "fillcarrBox") {
        $rows = array();
        $sql = "SELECT id_carreras, nombre_carrera FROM carreras";
        foreach ($dbh->query($sql) as $row) {
            $rows[] = $row;
        }
    header('Content-type: text/json');  
    print json_encode($rows);
    }
                   
    /*** query para poblar listBox de grados ***/
    else if($_GET["action"]== "fillgrdBox"){
        $rows = array();
        $sql = ("SELECT id_grados, grado FROM grados WHERE id_g_carreras = " . $_GET["id_carreras"]. ";");
            foreach ($dbh->query($sql) as $row) {
            $row1 = str_replace( array( '\'', '"', ',' , ';', '<', '>' ), ' ', $row);
            $rows[] = $row1;
        }
    header('Content-type: text/json');  
    print json_encode($rows);               
    }
    
    /*** query's para filtrar búsquda según diferentes criterios ***/
    else if($_GET["action"]== "infAlumnos"){        
    $id_filtro = $_GET['id_filtro'];
    $id_secciones = $_GET['id_secciones'];
    $rows = array();
    if (($id_secciones  == 'Default')){
    /*** estrae todos los alumnos según filtro***/                    
    switch ($id_filtro) {
        case 'cod_mineduc' :
            $sql = ("SELECT id_alumnos, id_a_secciones, id_a_grados, id_a_carreras, nombres_alumnos, apellidos_alumnos, genero, edad,
            CURDATE(), (YEAR(CURDATE()) - YEAR(fecha_nacimiento))-
            (RIGHT(CURDATE(),5) < RIGHT(fecha_nacimiento,5)) As edad                
            FROM alumnos WHERE cod_mineduc = 0 ORDER BY id_a_secciones, id_a_carreras LIMIT 100;");
            foreach ($dbh->query($sql) as $row) {
                $rows[] = $row;
            }
        break;
        case 'estatus_mineduc' :
            $sql = ("SELECT id_alumnos, id_a_secciones, id_a_grados, id_a_carreras, nombres_alumnos, apellidos_alumnos, genero, edad,
            CURDATE(), (YEAR(CURDATE()) - YEAR(fecha_nacimiento))-
            (RIGHT(CURDATE(),5) < RIGHT(fecha_nacimiento,5)) As edad                
            FROM alumnos WHERE estatus_mineduc = 'PENDIENTE' ORDER BY id_a_secciones, id_a_carreras LIMIT 100;");
            foreach ($dbh->query($sql) as $row) {
                $rows[] = $row;
            }
        break;
        case 'complecion_estatus':
            $sql = ("SELECT a.id_alumnos, a.id_a_secciones, a.id_a_grados, a.id_a_carreras, a.nombres_alumnos, a.apellidos_alumnos,
            a.genero, e.complecion_estatus, edad, CURDATE(), (YEAR(CURDATE()) - YEAR(fecha_nacimiento))-
            (RIGHT(CURDATE(),5) < RIGHT(fecha_nacimiento,5)) As edad                
            FROM grados AS a INNER JOIN Expedientes e 
            ON a.id_alumnos = e.id_ex_alumnos
            WHERE e.complecion_estatus = 'INCOMPLETO' ORDER BY a.id_a_secciones, a.id_a_carreras LIMIT 100;");
            foreach ($dbh->query($sql) as $row) {
                $rows[] = $row;
            }                                
            break;            
        case 'es_nuevo_ingreso':
            $sql = ("SELECT id_alumnos, id_a_secciones, id_a_grados, id_a_carreras, nombres_alumnos, apellidos_alumnos, genero, edad, 
            CURDATE(), (YEAR(CURDATE()) - YEAR(fecha_nacimiento))-
            (RIGHT(CURDATE(),5) < RIGHT(fecha_nacimiento,5)) As edad                
            FROM alumnos WHERE es_nuevo_ingreso = 'SI' ORDER BY id_a_secciones, id_a_carreras LIMIT 100;");
            foreach ($dbh->query($sql) as $row) {
                $rows[] = $row;
            }                                
            break;            
        case 'estatus_grd_anterior':
            $sql = ("SELECT id_alumnos, id_a_secciones, id_a_grados, id_a_carreras, nombres_alumnos, apellidos_alumnos, genero, edad,
            CURDATE(), (YEAR(CURDATE()) - YEAR(fecha_nacimiento))-
            (RIGHT(CURDATE(),5) < RIGHT(fecha_nacimiento,5)) As edad                
            FROM alumnos WHERE estatus_grd_anterior LIKE 'PROMOVIDO' ORDER BY id_a_secciones, id_a_carreras LIMIT 100;");
            foreach ($dbh->query($sql) as $row) {
                $rows[] = $row;
            }                                
            break;            
        case 'edad16':
            $sql = ("SELECT id_alumnos, id_a_secciones, id_a_grados, id_a_carreras, nombres_alumnos, apellidos_alumnos, genero, edad,
            CURDATE(), (YEAR(CURDATE()) - YEAR(fecha_nacimiento))-
            (RIGHT(CURDATE(),5) < RIGHT(fecha_nacimiento,5)) As edad                
            FROM alumnos HAVING edad < 16 ORDER BY id_a_secciones, id_a_carreras LIMIT 100");                                
            foreach ($dbh->query($sql) as $row) {
                $rows[] = $row;
            }                                
            break;            
        case 'edad18':
            $sql = ("SELECT id_alumnos, id_a_secciones, id_a_grados, id_a_carreras, nombres_alumnos, apellidos_alumnos, genero, edad,
            CURDATE(), (YEAR(CURDATE()) - YEAR(fecha_nacimiento))-
            (RIGHT(CURDATE(),5) < RIGHT(fecha_nacimiento,5)) As edad                
            FROM alumnos HAVING edad >= 16 AND edad <= 18 ORDER BY id_a_secciones, id_a_carreras LIMIT 100");                                
            foreach ($dbh->query($sql) as $row) {
                $rows[] = $row;
            }                                
            break;            
        case 'edad19':
            $sql = ("SELECT id_alumnos, id_a_secciones, id_a_grados, id_a_carreras, nombres_alumnos, apellidos_alumnos, genero, edad,
            CURDATE(), (YEAR(CURDATE()) - YEAR(fecha_nacimiento))-
            (RIGHT(CURDATE(),5) < RIGHT(fecha_nacimiento,5)) As edad                
            FROM alumnos HAVING edad > 18 ORDER BY id_a_secciones, id_a_carreras LIMIT 100");                                
            foreach ($dbh->query($sql) as $row) {
                $rows[] = $row;
            }                                
            break;            
        case 'todos':
            if ($id_secciones >= 1){
                $sql = ("SELECT id_alumnos, id_a_secciones, id_a_grados, id_a_carreras, nombres_alumnos, apellidos_alumnos, genero, edad,
                CURDATE(), (YEAR(CURDATE()) - YEAR(fecha_nacimiento))-
                (RIGHT(CURDATE(),5) < RIGHT(fecha_nacimiento,5)) As edad                
                FROM alumnos WHERE id_a_secciones = " .$_GET['id_secciones'] . " ORDER BY id_a_secciones, id_a_carreras");
                foreach ($dbh->query($sql) as $row) {
                $rows[] = $row;
            }                
            }else{
                $sql = ("SELECT id_alumnos, id_a_secciones, id_a_grados, id_a_carreras, nombres_alumnos, apellidos_alumnos, genero, edad,
                CURDATE(), (YEAR(CURDATE()) - YEAR(fecha_nacimiento))-
                (RIGHT(CURDATE(),5) < RIGHT(fecha_nacimiento,5)) As edad                
                FROM alumnos ORDER BY id_a_secciones, id_a_carreras LIMIT 100" );
                foreach ($dbh->query($sql) as $row) {
                $rows[] = $row;
            }                                
            }
        break;
        default:
            $sql = ("SELECT id_alumnos, id_a_secciones, id_a_grados, id_a_carreras, nombres_alumnos, apellidos_alumnos, genero, edad,
            CURDATE(), (YEAR(CURDATE()) - YEAR(fecha_nacimiento))-
            (RIGHT(CURDATE(),5) < RIGHT(fecha_nacimiento,5)) As edad 
            FROM alumnos ORDER BY id_a_secciones, id_a_carreras LIMIT 100");
            foreach ($dbh->query($sql) as $row) {
            $rows[] = $row;
        }
        break;
    }
    }else if($id_secciones >= 1){

    /*** estrae alumnos de una sección, según filtro***/                            
    switch ($id_filtro) {
        case 'cod_mineduc':
            $sql = ("SELECT id_alumnos, id_a_secciones, id_a_grados, id_a_carreras, nombres_alumnos, apellidos_alumnos, genero, edad,
            CURDATE(), (YEAR(CURDATE()) - YEAR(fecha_nacimiento))-
            (RIGHT(CURDATE(),5) < RIGHT(fecha_nacimiento,5)) As edad                
            FROM alumnos WHERE id_a_secciones = " . $_GET["id_secciones"] ."
            AND cod_mineduc = 0 ORDER BY id_a_secciones, id_a_carreras;");
            foreach ($dbh->query($sql) as $row) {
                $rows[] = $row;
            }                                
            break;            
        case 'estatus_mineduc':
            $sql = ("SELECT id_alumnos, id_a_secciones, id_a_grados, id_a_carreras, nombres_alumnos, apellidos_alumnos, genero, edad,
            CURDATE(), (YEAR(CURDATE()) - YEAR(fecha_nacimiento))-
            (RIGHT(CURDATE(),5) < RIGHT(fecha_nacimiento,5)) As edad                
            FROM alumnos WHERE id_a_secciones = " . $_GET["id_secciones"] ."
            AND estatus_mineduc = 'PENDIENTE' ORDER BY id_a_secciones, id_a_carreras;");
            foreach ($dbh->query($sql) as $row) {
                $rows[] = $row;
            }                                
            break;            
        case 'complecion_estatus':
            $sql = ("SELECT a.id_alumnos, a.id_a_secciones, id_a_grados, id_a_carreras, a.nombres_alumnos, a.apellidos_alumnos,
            a.genero, e.complecion_estatus, edad, CURDATE(), (YEAR(CURDATE()) - YEAR(fecha_nacimiento))-
            (RIGHT(CURDATE(),5) < RIGHT(fecha_nacimiento,5)) As edad                
            FROM alumnos AS a INNER JOIN Expedientes e 
            ON a.id_alumnos = e.id_ex_alumnos WHERE a.id_a_secciones = " . $_GET["id_secciones"] ."
            AND e.complecion_estatus = 'INCOMPLETO' ORDER BY a.id_a_secciones, a.id_a_carreras;");
            foreach ($dbh->query($sql) as $row) {
                $rows[] = $row;
            }                                
            break;            
        case 'es_nuevo_ingreso':
            $sql = ("SELECT id_alumnos, id_a_secciones, id_a_grados, id_a_carreras, nombres_alumnos, apellidos_alumnos, genero, edad,
            CURDATE(), (YEAR(CURDATE()) - YEAR(fecha_nacimiento))-
            (RIGHT(CURDATE(),5) < RIGHT(fecha_nacimiento,5)) As edad                
            FROM alumnos WHERE id_a_secciones = " . $_GET["id_secciones"] ."
            AND es_nuevo_ingreso = 'SI' ORDER BY id_a_secciones, id_a_carreras;");
            foreach ($dbh->query($sql) as $row) {
                $rows[] = $row;
            }                                
            break;            
        case 'estatus_grd_anterior':
            $sql = ("SELECT id_alumnos, id_a_secciones, id_a_grados, id_a_carreras, nombres_alumnos, apellidos_alumnos, genero, edad,
            CURDATE(), (YEAR(CURDATE()) - YEAR(fecha_nacimiento))-
            (RIGHT(CURDATE(),5) < RIGHT(fecha_nacimiento,5)) As edad                
            FROM alumnos WHERE id_a_secciones = " . $_GET["id_secciones"] ."
            AND estatus_grd_anterior LIKE 'PROMOVIDO' ORDER BY id_a_secciones, id_a_carreras;");
            foreach ($dbh->query($sql) as $row) {
                $rows[] = $row;
            }                                
            break;            
        case 'edad16':
            $sql = ("SELECT id_alumnos, id_a_secciones, id_a_grados, id_a_carreras, nombres_alumnos, apellidos_alumnos, genero, edad,
            CURDATE(), (YEAR(CURDATE()) - YEAR(fecha_nacimiento))-
            (RIGHT(CURDATE(),5) < RIGHT(fecha_nacimiento,5)) As edad                
            FROM alumnos WHERE id_a_secciones = " . $_GET["id_secciones"] ." HAVING edad < 16  ORDER BY id_a_secciones, id_a_carreras");                                
            foreach ($dbh->query($sql) as $row) {
                $rows[] = $row;
            }                                
            break;            
        case 'edad18':
            $sql = ("SELECT id_alumnos, id_a_secciones, id_a_grados, id_a_carreras, nombres_alumnos, apellidos_alumnos, genero, edad,
            CURDATE(), (YEAR(CURDATE()) - YEAR(fecha_nacimiento))-
            (RIGHT(CURDATE(),5) < RIGHT(fecha_nacimiento,5)) As edad                
            FROM alumnos WHERE id_a_secciones = " . $_GET["id_secciones"] ." HAVING edad >= 16 AND edad <= 18  ORDER BY id_a_secciones, id_a_carreras");                                
            foreach ($dbh->query($sql) as $row) {
                $rows[] = $row;
            }                                
            break;            
        case 'edad19':
            $sql = ("SELECT id_alumnos, id_a_secciones, id_a_grados, id_a_carreras, nombres_alumnos, apellidos_alumnos, genero, edad,
            CURDATE(), (YEAR(CURDATE()) - YEAR(fecha_nacimiento))-
            (RIGHT(CURDATE(),5) < RIGHT(fecha_nacimiento,5)) As edad                
            FROM alumnos WHERE id_a_secciones = " . $_GET["id_secciones"] ." HAVING edad > 18  ORDER BY id_a_secciones, id_a_carreras");                                
            foreach ($dbh->query($sql) as $row) {
                $rows[] = $row;
            }                                
            break;            
        case 'todos':
            $sql = ("SELECT id_alumnos, id_a_secciones, id_a_grados, id_a_carreras, nombres_alumnos, apellidos_alumnos, genero, edad,
            CURDATE(), (YEAR(CURDATE()) - YEAR(fecha_nacimiento))-
            (RIGHT(CURDATE(),5) < RIGHT(fecha_nacimiento,5)) As edad                
            FROM alumnos WHERE id_a_secciones = " .$_GET['id_secciones'] . " ORDER BY id_alumnos, id_a_secciones, id_a_carreras LIMIT 100");
            foreach ($dbh->query($sql) as $row) {
            $rows[] = $row;
        }
        break;
        default:                
            $sql = ("SELECT id_alumnos, id_a_secciones, id_a_grados, id_a_carreras, nombres_alumnos, apellidos_alumnos, genero, edad,
            CURDATE(), (YEAR(CURDATE()) - YEAR(fecha_nacimiento))-
            (RIGHT(CURDATE(),5) < RIGHT(fecha_nacimiento,5)) As edad 
            FROM alumnos WHERE id_a_secciones = " . $_GET['id_secciones'] . " ORDER BY id_alumnos, id_a_secciones, id_a_carreras LIMIT 40");
            foreach ($dbh->query($sql) as $row) {
                $rows[] = $row;
            }                                                               
            break;
        }
    }
    header('Content-type: text/json' );
    print json_encode($rows);
    }
    else if($_GET["action"]== "infAlumnosPorgrd"){
        $id_filtro = $_GET['id_filtro'];                        
        $id_carreras = $_GET['id_carreras'];
        $id_grados = $_GET['id_grados'];
        $rows = array();          

    /*** estrae alumnos según carrera, grado y filtro***/                              
    switch ($id_filtro) {
        case 'cod_mineduc':
            if ($id_grados >= 1){
                $sql = ("SELECT id_alumnos, id_a_secciones, id_a_grados, id_a_carreras, nombres_alumnos, apellidos_alumnos, genero, edad,
                CURDATE(), (YEAR(CURDATE()) - YEAR(fecha_nacimiento))-
                (RIGHT(CURDATE(),5) < RIGHT(fecha_nacimiento,5)) As edad                
                FROM alumnos WHERE id_a_carreras = " . $_GET["id_carreras"] ." AND id_a_grados = " . $_GET["id_grados"] ."
                AND cod_mineduc = 0 ORDER BY id_a_secciones, id_a_grados LIMIT 100;");
                foreach ($dbh->query($sql) as $row) {
                    $rows[] = $row;
                }                                                                                    
            }else{
                $sql = ("SELECT id_alumnos, id_a_secciones, id_a_grados, id_a_carreras, nombres_alumnos, apellidos_alumnos, genero, edad,
                CURDATE(), (YEAR(CURDATE()) - YEAR(fecha_nacimiento))-
                (RIGHT(CURDATE(),5) < RIGHT(fecha_nacimiento,5)) As edad                
                FROM alumnos WHERE id_a_carreras = " . $_GET["id_carreras"] ."                
                AND cod_mineduc = 0 ORDER BY id_a_secciones, id_a_grados LIMIT 100;");
                foreach ($dbh->query($sql) as $row) {
                    $rows[] = $row;
                }                                                                                    
            }
        break;
        case 'estatus_mineduc' :
            if ($id_grados >= 1){
                $sql = ("SELECT id_alumnos, id_a_secciones, id_a_grados, id_a_carreras, nombres_alumnos, apellidos_alumnos, genero, edad,
                CURDATE(), (YEAR(CURDATE()) - YEAR(fecha_nacimiento))-
                (RIGHT(CURDATE(),5) < RIGHT(fecha_nacimiento,5)) As edad                
                FROM alumnos WHERE id_a_carreras = " . $_GET["id_carreras"] ." AND id_a_grados = " . $_GET["id_grados"] ."
                AND estatus_mineduc = 'PENDIENTE' ORDER BY id_a_secciones, id_a_grados LIMIT 100;");
                foreach ($dbh->query($sql) as $row) {
                    $rows[] = $row;
                }                                                                                    
            }else{
                $sql = ("SELECT id_alumnos, id_a_secciones, id_a_grados, id_a_carreras, nombres_alumnos, apellidos_alumnos, genero, edad,
                CURDATE(), (YEAR(CURDATE()) - YEAR(fecha_nacimiento))-
                (RIGHT(CURDATE(),5) < RIGHT(fecha_nacimiento,5)) As edad                
                FROM alumnos WHERE id_a_carreras = " . $_GET["id_carreras"] ."
                AND estatus_mineduc = 'PENDIENTE' ORDER BY id_a_secciones, id_a_grados LIMIT 100;");
                foreach ($dbh->query($sql) as $row) {
                    $rows[] = $row;
                }                                                                                    
            }
        break;
        case 'complecion_estatus':
            if ($id_grados >= 1){
            $sql = ("SELECT a.id_alumnos, a.id_a_secciones, id_a_grados, id_a_carreras, a.nombres_alumnos, a.apellidos_alumnos,
            a.genero, e.complecion_estatus, edad, CURDATE(), (YEAR(CURDATE()) - YEAR(fecha_nacimiento))-
            (RIGHT(CURDATE(),5) < RIGHT(fecha_nacimiento,5)) As edad                
            FROM alumnos AS a INNER JOIN Expedientes e 
            ON a.id_alumnos = e.id_ex_alumnos WHERE a.id_a_carreras = " . $_GET["id_carreras"] ." AND a.id_a_grados = " . $_GET["id_grados"] ."
            AND e.complecion_estatus = 'INCOMPLETO' ORDER BY a.id_a_grados, a.id_a_secciones LIMIT 100;");
            foreach ($dbh->query($sql) as $row) {
                $rows[] = $row;
            }                                
            }else{
            $sql = ("SELECT a.id_alumnos, a.id_a_secciones, id_a_grados, id_a_carreras, a.nombres_alumnos, a.apellidos_alumnos,
            a.genero, e.complecion_estatus, edad, CURDATE(), (YEAR(CURDATE()) - YEAR(fecha_nacimiento))-
            (RIGHT(CURDATE(),5) < RIGHT(fecha_nacimiento,5)) As edad                
            FROM alumnos AS a INNER JOIN Expedientes e 
            ON a.id_alumnos = e.id_ex_alumnos WHERE a.id_a_carreras = " . $_GET["id_carreras"] ."
            AND e.complecion_estatus = 'INCOMPLETO' ORDER BY a.id_a_grados, a.id_a_secciones LIMIT 100;");
            foreach ($dbh->query($sql) as $row) {
                $rows[] = $row;
            }                                
            }
            break;            
        case 'es_nuevo_ingreso':
            if ($id_grados >= 1){
                $sql = ("SELECT id_alumnos, id_a_secciones, id_a_grados, id_a_carreras, nombres_alumnos, apellidos_alumnos, genero, edad,
                CURDATE(), (YEAR(CURDATE()) - YEAR(fecha_nacimiento))-
                (RIGHT(CURDATE(),5) < RIGHT(fecha_nacimiento,5)) As edad                
                FROM alumnos WHERE id_a_carreras = " . $_GET["id_carreras"] ." AND id_a_grados = " . $_GET["id_grados"] ."
                AND es_nuevo_ingreso = 'SI' ORDER BY id_a_secciones, id_a_grados LIMIT 100;");
                foreach ($dbh->query($sql) as $row) {
                    $rows[] = $row;
                }                                                                                    
            }else{
                $sql = ("SELECT id_alumnos, id_a_secciones, id_a_grados, id_a_carreras, nombres_alumnos, apellidos_alumnos, genero, edad,
                CURDATE(), (YEAR(CURDATE()) - YEAR(fecha_nacimiento))-
                (RIGHT(CURDATE(),5) < RIGHT(fecha_nacimiento,5)) As edad                
                FROM alumnos WHERE id_a_carreras = " . $_GET["id_carreras"] ."
                AND es_nuevo_ingreso = 'SI' ORDER BY id_a_secciones, id_a_grados LIMIT 100;");
                foreach ($dbh->query($sql) as $row) {
                    $rows[] = $row;
                }                                                                                    
            }
            break;            
        case 'estatus_grd_anterior':
            if ($id_grados >= 1){
            $sql = ("SELECT id_alumnos, id_a_secciones, id_a_grados, id_a_carreras, nombres_alumnos, apellidos_alumnos, genero, edad,
            CURDATE(), (YEAR(CURDATE()) - YEAR(fecha_nacimiento))-
            (RIGHT(CURDATE(),5) < RIGHT(fecha_nacimiento,5)) As edad                
            FROM alumnos WHERE id_a_carreras = " . $_GET["id_carreras"] ."
            AND id_a_grados = " . $_GET["id_grados"] ."
            AND estatus_grd_anterior LIKE 'PROMOVIDO' ORDER BY id_a_secciones, id_a_grados LIMIT 100;");
            foreach ($dbh->query($sql) as $row) {
                $rows[] = $row;
            }                                                
            }else{
            $sql = ("SELECT id_alumnos, id_a_secciones, id_a_grados, id_a_carreras, nombres_alumnos, apellidos_alumnos, genero, edad,
            CURDATE(), (YEAR(CURDATE()) - YEAR(fecha_nacimiento))-
            (RIGHT(CURDATE(),5) < RIGHT(fecha_nacimiento,5)) As edad                
            FROM alumnos WHERE id_a_carreras = " . $_GET["id_carreras"] ."
            AND estatus_grd_anterior LIKE 'PROMOVIDO' ORDER BY id_a_secciones, id_a_grados LIMIT 100;");
            foreach ($dbh->query($sql) as $row) {
                $rows[] = $row;
            }                                                                
            }
            break;            
        case 'edad16':
            if ($id_grados >= 1){
                $sql = ("SELECT id_alumnos, id_a_secciones, id_a_grados, id_a_carreras, nombres_alumnos, apellidos_alumnos, genero, edad,
                CURDATE(), (YEAR(CURDATE()) - YEAR(fecha_nacimiento))-
                (RIGHT(CURDATE(),5) < RIGHT(fecha_nacimiento,5)) As edad                
                FROM alumnos WHERE id_a_carreras = " . $_GET["id_carreras"] ." AND id_a_grados = " . $_GET["id_grados"] ."
                HAVING edad < 16 ORDER BY id_a_secciones, id_a_grados LIMIT 100;");
                foreach ($dbh->query($sql) as $row) {
                    $rows[] = $row;
                }                                                                                    
            }else{
                $sql = ("SELECT id_alumnos, id_a_secciones, id_a_grados, id_a_carreras, nombres_alumnos, apellidos_alumnos, genero, edad,
                CURDATE(), (YEAR(CURDATE()) - YEAR(fecha_nacimiento))-
                (RIGHT(CURDATE(),5) < RIGHT(fecha_nacimiento,5)) As edad                
                FROM alumnos WHERE id_a_carreras = " . $_GET["id_carreras"] ."
                HAVING edad < 16 ORDER BY id_a_secciones, id_a_grados LIMIT 100;");
                foreach ($dbh->query($sql) as $row) {
                    $rows[] = $row;
                }                                                                                    
            }
            break;            
        case 'edad18':
            if ($id_grados >= 1){
                $sql = ("SELECT id_alumnos, id_a_secciones, id_a_grados, id_a_carreras, nombres_alumnos, apellidos_alumnos, genero, edad,
                CURDATE(), (YEAR(CURDATE()) - YEAR(fecha_nacimiento))-
                (RIGHT(CURDATE(),5) < RIGHT(fecha_nacimiento,5)) As edad                
                FROM alumnos WHERE id_a_carreras = " . $_GET["id_carreras"] ." AND id_a_grados = " . $_GET["id_grados"] ."
                HAVING edad >= 16 AND edad <= 18 ORDER BY id_a_secciones, id_a_grados LIMIT 100;");
                foreach ($dbh->query($sql) as $row) {
                    $rows[] = $row;
                }                                                                                    
            }else{
                $sql = ("SELECT id_alumnos, id_a_secciones, id_a_grados, id_a_carreras, nombres_alumnos, apellidos_alumnos, genero, edad,
                CURDATE(), (YEAR(CURDATE()) - YEAR(fecha_nacimiento))-
                (RIGHT(CURDATE(),5) < RIGHT(fecha_nacimiento,5)) As edad                
                FROM alumnos WHERE id_a_carreras = " . $_GET["id_carreras"] ."
                HAVING edad >= 16 AND edad <= 18 ORDER BY id_a_secciones, id_a_grados LIMIT 100;");
                foreach ($dbh->query($sql) as $row) {
                    $rows[] = $row;
                }                                                                                    
            }
            break;            
        case 'edad19':
            if ($id_grados >= 1){
                $sql = ("SELECT id_alumnos, id_a_secciones, id_a_grados, id_a_carreras, nombres_alumnos, apellidos_alumnos, genero, edad,
                CURDATE(), (YEAR(CURDATE()) - YEAR(fecha_nacimiento))-
                (RIGHT(CURDATE(),5) < RIGHT(fecha_nacimiento,5)) As edad                
                FROM alumnos WHERE id_a_carreras = " . $_GET["id_carreras"] ." AND id_a_grados = " . $_GET["id_grados"] ."
                 HAVING edad > 18 ORDER BY id_a_secciones, id_a_grados LIMIT 100;");
                foreach ($dbh->query($sql) as $row) {
                    $rows[] = $row;
                }                                                                                    
            }else{
                $sql = ("SELECT id_alumnos, id_a_secciones, id_a_grados, id_a_carreras, nombres_alumnos, apellidos_alumnos, genero, edad,
                CURDATE(), (YEAR(CURDATE()) - YEAR(fecha_nacimiento))-
                (RIGHT(CURDATE(),5) < RIGHT(fecha_nacimiento,5)) As edad                
                FROM alumnos WHERE id_a_carreras = " . $_GET["id_carreras"] ."
                 HAVING edad > 18 ORDER BY id_a_secciones, id_a_grados LIMIT 100;");
                foreach ($dbh->query($sql) as $row) {
                    $rows[] = $row;
                }                                                                                    
            }
            break;            
        case 'todos':
            if ($id_grados >= 1){
            $sql = ("SELECT id_alumnos, id_a_secciones, id_a_grados, id_a_carreras, nombres_alumnos, apellidos_alumnos, genero, edad,
            CURDATE(), (YEAR(CURDATE()) - YEAR(fecha_nacimiento))-
            (RIGHT(CURDATE(),5) < RIGHT(fecha_nacimiento,5)) As edad                
            FROM alumnos WHERE id_a_carreras = " . $_GET["id_carreras"] ." AND id_a_grados = " . $_GET["id_grados"] ."
            ORDER BY id_a_grados, id_a_secciones LIMIT 100");
            foreach ($dbh->query($sql) as $row) {
                $rows[] = $row;
            }                
            }else{
            $sql = ("SELECT id_alumnos, id_a_secciones, id_a_grados, id_a_carreras, nombres_alumnos, apellidos_alumnos, genero, edad,
            CURDATE(), (YEAR(CURDATE()) - YEAR(fecha_nacimiento))-
            (RIGHT(CURDATE(),5) < RIGHT(fecha_nacimiento,5)) As edad                
            FROM alumnos WHERE  id_a_carreras = " . $_GET["id_carreras"] ." ORDER BY id_a_grados, id_a_secciones LIMIT 100");
            foreach ($dbh->query($sql) as $row) {
                $rows[] = $row;
            }                                
            }
        break;
        default:
            if ($id_grados >= 1){
            $sql = ("SELECT id_alumnos, id_a_secciones, id_a_grados, id_a_carreras, nombres_alumnos, apellidos_alumnos, genero, edad,
            CURDATE(), (YEAR(CURDATE()) - YEAR(fecha_nacimiento))-
            (RIGHT(CURDATE(),5) < RIGHT(fecha_nacimiento,5)) As edad                
            FROM alumnos WHERE id_a_carreras = " . $_GET["id_carreras"] ." AND id_a_grados = " . $_GET["id_grados"] ."
            ORDER BY id_a_grados, id_a_secciones LIMIT 100");
            foreach ($dbh->query($sql) as $row) {
                $rows[] = $row;
            }                
            }else{
            $sql = ("SELECT id_alumnos, id_a_secciones, id_a_grados, id_a_carreras, nombres_alumnos, apellidos_alumnos, genero, edad,
            CURDATE(), (YEAR(CURDATE()) - YEAR(fecha_nacimiento))-
            (RIGHT(CURDATE(),5) < RIGHT(fecha_nacimiento,5)) As edad                
            FROM alumnos WHERE id_a_carreras = " . $_GET["id_carreras"] ." ORDER BY id_a_grados, id_a_secciones LIMIT 100");
            foreach ($dbh->query($sql) as $row) {
                $rows[] = $row;
            }
            break;            
            }                
    }
    header('Content-type: text/json' );
    print json_encode($rows);            
}

    /* auto filtrado de alumnos */
    else if ($_GET["action"]== "autoCompletado"){
        $search = $_POST['service'];
        $query_services = $dbh->query("SELECT id_alumnos, nombres_alumnos FROM alumnos WHERE nombres_alumnos LIKE '" . $search . "%' LIMIT 10");
        while ($row_services = $query_services->fetch()) {
            echo '<div><a  class="suggest-element" data="' . $row_services['nombres_alumnos'] . '" id="service' .
            $row_services['id_alumnos'] . '">' . utf8_encode($row_services['nombres_alumnos']) . '</a></div>';
        }
    header( 'Content-type: text/html; charset=iso-8859-1' );
    print json_encode($row_services);                          
    }

    /* búsqueda por alumno */
    else if ($_GET["action"]== "infAlumno"){
        $alumno = $_GET['alumno'];
        $rows = array();          
        $sql = ("SELECT id_alumnos, id_a_secciones, id_a_grados, id_a_carreras, nombres_alumnos, apellidos_alumnos, genero, edad,
        CURDATE(), (YEAR(CURDATE()) - YEAR(fecha_nacimiento))-
        (RIGHT(CURDATE(),5) < RIGHT(fecha_nacimiento,5)) As edad FROM alumnos 
        WHERE nombres_alumnos LIKE '" . $alumno . "' ");
        foreach ($dbh->query($sql) as $row) {
            $rows[] = $row;
        }                                                                       
    header('Content-type: text/json' );
    print json_encode($rows);                  
    }    
                
    /* close the database connection */
    $dbh = null;
    if($dbh){
        var_dump($dbh, " connection still active");
    }
}
    catch(Exception $ex){
    $ex->getMessage();
    print $ex;
    }               
?>