<?phptry{        header("Content-Type: text/html;charset=utf-8");    require('../DB.php');     //    $dbh = null; don't forget to close the connection!	//Getting records (listAction)	if($_GET["action"] == "list"){        if(!$result = ("SELECT * FROM tutores WHERE tut_id_alumnos = " . $_GET["id_alumnos"]. " ;")){            throw new Exception('Query failed: '. mysql_error($dbh));        }		//Add all records to an array		$rows = array();            foreach ($dbh->query($result) as $row) {            $rows[] = $row;        }                      		//Return result to jTable		$jTableResult = array();		$jTableResult['Result'] = "OK";		$jTableResult['Records'] = $rows;		print json_encode($jTableResult);	}    	//Creating a new record (createAction)	    else if ($_GET["action"] == "create") {        if (!$result = $dbh->prepare("INSERT INTO tutores(nombres_tutores, apellidos_tutores,		edad_tutores, dpi, relacion_con_alumno, tel_casa_tutor, cell_tutor, direccion_tutor, tut_id_alumnos,		tut_id_grados, tut_id_secciones, tut_id_carreras)        VALUES('" . $_POST["nombres_tutores"] . "','" . $_POST["apellidos_tutores"] . "', '"            . $_POST["edad_tutores"] . "','" . $_POST["dpi"] . "','" . $_POST["relacion_con_alumno"] . "','"            . $_POST["tel_casa_tutor"] . "','" . $_POST["cell_tutor"] . "','" . $_POST["direccion_tutor"] . "',"            . $_POST["tut_id_alumnos"] . "," . $_POST["tut_id_grados"] . "," . $_POST["tut_id_secciones"] . ","            . $_POST["tut_id_carreras"] . " );")) {            throw new Exception('Query failed: ' . mysql_error($dbh));        }        $result->execute();        //Get last inserted record (to return to jTable)        $result = $dbh->prepare("SELECT * FROM tutores WHERE id_tutores = LAST_INSERT_ID();");        $result->execute();        $row = $result->fetch(PDO::FETCH_ASSOC);        //Return result to jTable        $jTableResult = array();        $jTableResult['Result'] = "OK";        $jTableResult['Record'] = $row;        print json_encode($jTableResult);    }        //Updating a record (updateAction)	else if($_GET["action"] == "update"){		if (!$result = $dbh->prepare("UPDATE tutores SET          nombres_tutores = '" . $_POST["nombres_tutores"] . "', apellidos_tutores = '"		. $_POST["apellidos_tutores"] . "', edad_tutores = '" . $_POST["edad_tutores"] ."', dpi = '" . $_POST["dpi"] ."', relacion_con_alumno = '"		. $_POST["relacion_con_alumno"] . "', tel_casa_tutor = '" . $_POST["tel_casa_tutor"] . "', cell_tutor = '" . $_POST["cell_tutor"] ."', direccion_tutor = '"		. $_POST["direccion_tutor"] ."', tut_id_alumnos = " . $_POST["tut_id_alumnos"] .", tut_id_grados = " . $_POST["tut_id_grados"] . ", tut_id_secciones = "		. $_POST["tut_id_secciones"] .", tut_id_carreras = " . $_POST["tut_id_carreras"] . "	     WHERE id_tutores = " . $_POST['id_tutores']. " ;")){            throw new Exception('Query failed: '. mysql_error($dbh));			                    }        $result->execute();        //Return result to jTable		$jTableResult = array();		$jTableResult['Result'] = "OK";		print json_encode($jTableResult);	}    	//Deleting a record (deleteAction)	else if($_GET["action"] == "delete"){        if(!$result = $dbh->prepare("DELETE FROM tutores WHERE id_tutores = " . $_POST["id_tutores"] ." ; ")){            throw new Exception('Query failed: '. mysql_error($dbh));						        }        $result->execute();		//Return result to jTable		$jTableResult = array();		$jTableResult['Result'] = "OK";		print json_encode($jTableResult);	}    /* close the database connection */    $dbh = null;    if($dbh){        var_dump($dbh, " connection still active");    }}    //catch(Exception $ex){    catch(Exception $ex){    $ex->getMessage();    print $ex;    //Return error message	$jTableResult = array();	$jTableResult['Result'] = "ERROR";	$jTableResult['Message'] = $ex->getMessage();	print json_encode($jTableResult);}?>