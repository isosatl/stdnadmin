<?PHP
/*
File Name: importCSV.php
File URI: http://k-fez.com/
Description: This scripts verifies that a CSV file has been upload via HTTP POST and then inserts all rows into a MySQL database.
Author: Kevin Pheasey
Author URI: http://k-fez.com/
Version: 1.0
*/

/*
 * Comprobar que no hay error de carga
 * e imprimir el nombre del 
 */
if ($_FILES["file"]["error"] > 0) {
    echo "Erro: " . $_FILES["file"]["error"] . "<br />";
} else {
    echo "Upload: " . $_FILES["file"]["name"] . "<br />";
    echo "Type: " . $_FILES["file"]["type"] . "<br />";
    echo "Size: " . ($_FILES["file"]["size"] / 1024) . " Kb<br />";
    echo "Stored in: " . $_FILES["file"]["tmp_name"];    
    
}


/*  Copyright (C) 2010  Kevin Pheasey (email: kevin at k-fez.com)

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>.

*/
if($_FILES["file"]["type"] != "application/vnd.ms-excel"){
	die("This is not a CSV file.");
}
elseif(is_uploaded_file($_FILES['file']['tmp_name'])){
	//Connect to the database
	$dbhost = 'localhost';
	$dbuser = 'root';
	$dbpass = '';
	$dbname = 'studentadmindb';
	$link = mysql_connect($dbhost, $dbuser, $dbpass) or die('Error connecting to mysql server');
	mysql_select_db($dbname);
	
	//Process the CSV file
	$handle = fopen($_FILES['file']['tmp_name'], "r");
	$data = fgetcsv($handle, 1000, ","); //Remove if CSV file does not have column headings
    var_dump($data);
	while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
		$att0 = mysql_real_escape_string($data[0]);
		$att1 = mysql_real_escape_string($data[1]);
		$att2 = mysql_real_escape_string($data[2]);
		$att3 = mysql_real_escape_string($data[3]);
		$att4 = mysql_real_escape_string($data[4]);
		$att5 = mysql_real_escape_string($data[5]);
		$att6 = mysql_real_escape_string($data[6]);
		$att7 = mysql_real_escape_string($data[7]);
		$att8 = mysql_real_escape_string($data[8]);
		$att9 = mysql_real_escape_string($data[9]);
		$att10 = mysql_real_escape_string($data[10]);
		$att11 = mysql_real_escape_string($data[11]);
		$att12 = mysql_real_escape_string($data[12]);
		$att13 = mysql_real_escape_string($data[13]);
		$att14 = mysql_real_escape_string($data[14]);
		$att15 = mysql_real_escape_string($data[15]);
		$att16 = mysql_real_escape_string($data[16]);
		$att17 = mysql_real_escape_string($data[17]);
		$att18 = mysql_real_escape_string($data[18]);
		$att19 = mysql_real_escape_string($data[19]);
		
		if (!$sql = "INSERT INTO alumnos
					VALUES ('" . $att0 . "', '" . $att1 . "', '" . $att2 . "', '" . $att3 . "',
                            '" . $att4 . "', '" . $att5 . "', '" . $att6 . "', '" . $att7 . "',
                            '" . $att8 . "', '" . $att9 . "', '" . $att10 . "', '" . $att11 . "',
                            '" . $att12 . "', '" . $att13 . "', '" . $att14 . "', '" . $att15 . "',
                            '" . $att16 . "', '" . $att17 . "', '" . $att18 . "', '" . $att19 . "'
                    )"){
            throw new Exception('Query failed: '. mysql_error($link));                                
        }
		mysql_query($sql);
	}
	mysql_close($link);
	echo "CSV file successfully imported.";
}
else{
	die("You shouldn't be here");
}

//function util(){
//    $allowedExts = array("jpg", "jpeg", "gif", "png");
//    $extension = end(explode(".", $_FILES["file"]["name"]));
//    if ((($_FILES["file"]["type"] == "image/gif")
//    || ($_FILES["file"]["type"] == "image/jpeg")
//    || ($_FILES["file"]["type"] == "image/pjpeg"))
//    && ($_FILES["file"]["size"] < 20000))
//    && in_array($extension, $allowedExts))
//    {
//    if ($_FILES["file"]["error"] > 0)
//        {
//        echo "Return Code: " . $_FILES["file"]["error"] . "<br />";
//        }
//    else
//        {
//        echo "Upload: " . $_FILES["file"]["name"] . "<br />";
//        echo "Type: " . $_FILES["file"]["type"] . "<br />";
//        echo "Size: " . ($_FILES["file"]["size"] / 1024) . " Kb<br />";
//        echo "Temp file: " . $_FILES["file"]["tmp_name"] . "<br />";
//
//        if (file_exists("upload/" . $_FILES["file"]["name"]))
//        {
//        echo $_FILES["file"]["name"] . " already exists. ";
//        }
//        else
//        {
//        move_uploaded_file($_FILES["file"]["tmp_name"],
//        "upload/" . $_FILES["file"]["name"]);
//        echo "Stored in: " . "upload/" . $_FILES["file"]["name"];
//        }
//        }
//    }
//    else
//    {
//    echo "Invalid file";
//    }
  ?>
