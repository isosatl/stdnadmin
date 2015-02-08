<body>
	<form enctype="multipart/form-data" action="imports/importar1.php" method="POST">
		<p>Choose a file to upload : <input id="csv"name="file" type="file" onChange="GetFileInfo()"/></p>
		<p><input type="submit" value="Upload File" /></p>
	</form>
    <!-- div para mostrar progreso de la carga o errores -->
    <div style= "border:1px;" id="info"></div>
    <div style = "border: 1px;" id="error"></div>

    <script type="text/javascript">
        
    function GetFileInfo() {
    var csv = document.getElementById ("csv");
    var message = "";
    if ('files' in csv) {
        if (csv.files.length == 0) {
            message = "Please browse for one or more files.";
        } else {
            for (var i = 0; i < csv.files.length; i++) {
                message += "<br /><b>" + (i+1) + ". file</b><br />";
                var file = csv.files[i];
                if ('name' in file) {
                    message += "name: " + file.name + "<br />";
                }
                else {
                    message += "name: " + file.fileName + "<br />";
                }
                if ('size' in file) {
                    message += "size: " + file.size + " bytes <br />";
                }
                else {
                    message += "size: " + file.fileSize + " bytes <br />";
                }
                if ('mediaType' in file) {
                    message += "type: " + file.mediaType + "<br />";
                }
            }
        }
    } 
    else {
        if (csv.value == "") {
            message += "Please browse for one or more files.";
            message += "<br />Use the Control or Shift key for multiple selection.";
        }
        else {
            message += "Your browser doesn't support the files property!";
            message += "<br />The path of the selected file: " + csv.value;
        }
    }

    var info = document.getElementById ("info");
    info.innerHTML = message;
}        
    
    </script>
</body>
</html>
