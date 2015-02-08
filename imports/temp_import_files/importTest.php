<?php  

    include ROOT_DIR . '/includes/header.php';
    include ROOT_DIR . '/includes/navinformes.php';

//connect to the database 
$connect = mysql_connect("localhost","root",""); 
mysql_select_db("studentadmindb",$connect); //select the table 
// 

if ($_FILES[csv][size] > 0) { 

    //get the csv file 
    $file = $_FILES[csv][tmp_name]; 
    $handle = fopen($file,"r"); 
     
    //loop through the csv file and insert into database 
    do { 
        if ($data[0]) { 
            mysql_query("INSERT INTO Calificaciones (calificacion, impartida_por, promedio_anual, maestro_guia,
                        unidades_segun_grado, id_ca_cursos, id_ca_unidades, id_ca_alumnos, id_ca_grados, id_ca_secciones, id_ca_carreras)
                    VALUES 
                    ( 
                    '".addslashes($data[0])."', 
                    '".addslashes($data[1])."', 
                    '".addslashes($data[2])."', 
                    '".addslashes($data[3])."', 
                    '".addslashes($data[4])."', 
                    '".addslashes($data[5])."', 
                    '".addslashes($data[6])."', 
                    '".addslashes($data[7])."', 
                    '".addslashes($data[8])."', 
                    '".addslashes($data[9])."', 
                    '".addslashes($data[10])."' 
                ) 
            "); 
        } 
    } while ($data = fgetcsv($handle,1000,",","'")); 
    // 

    //redirect 
    header('Location: imports/importTest.php?success=1'); die; 

} 

?> 

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml"> 
<head> 
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" /> 
<title>Import a CSV File with PHP & MySQL</title> 
</head> 

<body id="import"> 

<?php if (!empty($_GET[success])) { echo "<b>Your file has been imported.</b><br><br>"; } //generic success notice ?> 

<form action="" method="post" enctype="multipart/form-data" name="form1" id="form1"> 
  Choose your file: <br /> 
  <input name="csv" type="file" id="csv" /> 
  <input type="submit" name="Submit" value="Submit" /> 
</form> 

</body> 
</html> 