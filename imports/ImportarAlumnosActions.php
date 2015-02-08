<?php
    //header( 'Location: http://localhost/studentAdministrator/index.php?importarcsv' ) ;

    /* Code at http://legend.ws/blog/tips-tricks/csv-php-mysql-import/
    /* Edit the entries below to reflect the appropriate values
    /******************************* */
    /***************************************
    * import csv file to mysql table
    **************************************/

    include '../init.php';
    require('../DB.php');     //$dbh = null; don't forget to close the connection!

    $fieldseparator = ",";
    $lineseparator = "\n";
    $filepath = ($_FILES['file1']['tmp_name']);
    $databasetable = "alumnos";

    /* Would you like to add an ampty field at the beginning of these records?
      /* This is useful if you have a table with the first field being an auto_increment integer
      /* and the csv file does not have such as empty field before the records.
      /* Set 1 for yes and 0 for no. ATTENTION: don't set to 1 if you are not sure.
      /* This can dump data in the wrong fields if this extra field does not exist in the table
      /******************************* */
    $addauto = 1;

    /* Would you like to save the mysql queries in a file? If yes set $save to 1.
      /* Permission on the file should be set to 777. Either upload a sample file through ftp and
      /* change the permissions, or execute at the prompt: touch output.sql && chmod 777 output.sql
      /******************************* */
    $save = 1;
    $outputfile = "../imports/files/output.sql";

    /********************************/
    if (!file_exists($filepath) || (!is_readable($filepath))) {
        echo "File not found. Make sure you specified the correct path.\n";
        exit;
    }


    /*
     * Abrir el archivo y verificar tamaño
     */
    $file = fopen($filepath, "r");
    if (!$file) {
        echo "Error opening data file.\n";
        exit;
    }
    $size = filesize($filepath);
    if (!$size) {
        echo "File is empty.\n";
        exit;
    }
    $tmpContarL = 1;
    $tmpContarL += count(file($filepath));
    
    /*
     * Leer el archivo y cerrarlo
     */
    $csvcontent = fread($file, $size);
    fclose($file);

    $lines = 0;
    $queries = "";
    $linearray = array();
    foreach (explode($lineseparator, $csvcontent) as $line) {
        $lines++;
        if ($lines == $tmpContarL){
            break;
        }  else if ($lines == 1){
            continue;
        }
        $line = trim($line, " \t");
        $line = str_replace("\r", "", $line);
        
        /************************************
          This line escapes the special character. remove it if entries are already escaped in the csv file
         ************************************/
        $line = str_replace("'", "\'", $line);
        
        /*************************************/
        $linearray = explode($fieldseparator, $line);

        /*************************************
         * convert dd-mm-yyyy To yyyy-mm-dd
         * ********************************** */
        $Fnacimiento = explode('/', $linearray[3]);
        $Fenrrolled= explode('/', $linearray[12]);
        $_day = $Fnacimiento[0];
        $_month = $Fnacimiento[1];
        $_year = $Fnacimiento[2];
        $linearray[3] = "$_year-$_month-$_day";                                        
        $_day = $Fenrrolled[0];
        $_month = $Fenrrolled[1];
        $_year = $Fenrrolled[2];
        $linearray[12] = "$_year-$_month-$_day";                                        
        
        $linemysql = implode("','", $linearray);
        if ($addauto)
            $query = "insert into $databasetable values('','$linemysql');";
        else
            $query = "insert into $databasetable values('$linemysql');";
        $queries .= $query . "\n";
        if (!$dbh->query($query)) {
            throw new Exception('Query failed: ' . mysql_error($dbh));
        }
    }
    $dbh = NULL;
    
    /** *************************** *
     * Generar los INSERT del archivo importado
     */
    if ($save) {
        if (!is_writable($outputfile)) {
            echo "File is not writable, check permissions.\n";
        } else {
            $file2 = fopen($outputfile, "w");
            if (!$file2) {
                echo "Error writing to the output file.\n";
            } else {
                fwrite($file2, $queries);
                fclose($file2);
            }
        }
    }
    echo "Found a total of $lines records in this csv file.\n";

?>