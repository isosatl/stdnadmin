<?php    //Script para determinar si se ha iniciado sessión y si es administrador.    if (session_id() == ''){        session_start();                    if (isset($_SESSION['privilegios'])){            if ($_SESSION['privilegios'] == 'admin'){                //mostrar contenido que corresponda a administrador                //print_r($_SESSION['privilegios']);                            }        }    }        if (!isset($_SESSION['usuario']) || (!isset($_SESSION['clave']))) {        $_SESSION['violation'] = 1;        header('Location: ./login.php');        exit();    } if (isset($_SESSION['timeout'])) {        $sessionTTL = time() - $_SESSION['timeout'];        if ($sessionTTL > $_SESSION['tiempoLimite']) {            $_SESSION['logedout'] = 1;            header('Location: ./login.php');            exit();        }    }    $_SESSION['timeout'] = time();    print_r($_SESSION);    include ROOT_DIR . '/includes/header.php';    include ROOT_DIR . '/includes/navinformes.php';    ?><title>Importar un archivo CSV con PHP y MySQL</title> </head> <body id="importar">     <!--div contenedor general-->    <div id="contenedor-importar">        <div class="div-importar">            <div class="titulos"><p class="p1-importar">Formulario para subir alumnos al sistema</p> </div>            <div><p class="p2-importar">Formulario para subir calificaciones al sistema</p> </div>            <div id="frm-importar-uno" class="frm-importar-cls">                <form action="imports/ImportarAlumnosActions.php" id="form1" name="form1"                     method="POST" enctype="multipart/form-data"> <br />                     <input type="hidden" name="MAX_FILE_SIZE" value="100000">                    <input class="input-cls" name="file1" type="file" id="csv" /><br />                     <input id="boton" type="submit" name="Submit" value="Enviar" />                </form>             </div>             <div id="frm-importar-dos" class="frm-importar-cls">                <form action="imports/ImportarNotasActions.php" id="form2" name="form2"                     method="POST" enctype="multipart/form-data"> <br />                     <input type="hidden" name="MAX_FILE_SIZE" value="100000">                    <input class="input-cls" name="file" type="file" id="calificaciones" /><br />                     <input id="boton" type="submit" name="Submit" value="Enviar" />                </form>             </div>        </div>                    <!-- div para mostrar progreso de la carga o errores -->    <div style= "border:1px;" id="info"></div>    <div style = "border: 1px;" id="error"></div>    <!-- div contenedor-->    </div>        <!-- Pie de esta página -->    <div id="footer_container"></div>    <script type="text/javascript">        /*    // wait for the DOM to be loaded     $(document).ready(function() {         // bind 'myForm' and provide a simple callback function         $('#form1').ajaxForm(function() {             //alert("Thank you for your comment!");         var queryString = $('#form1').formSerialize();        $.ajax("imports/importarActions.php?", queryString);        });     });     */       /*    $('#csv').change(function(e){        var queryString = $('#form1').formSerializa();        $.get("imports/importarActions.php?", queryString);    });    */       /*        $('#csv').change(function(e){        //var csv = document.getElementById("csv").value;        //alert("Esta es una prueba de envío" + csv);        var form = $('#form1');        $.ajax({            type: "POST",            url: form.attr('action'),            enctype: 'multipart/form-data',            data: form.serialize(),            success: function( response){                console.log( response);            }        });    });  *//* // when the DOM is ready$('#boton').click(function(e) {    // bind some code to the form's onsubmit handler            // $.post makes a POST XHR request, the first parameter takes the form's            // specified action            $.post("imports/importarActions.php",            $("form[name=form1]").attr('action'),            function(resp) {                if(resp == '1') {                    alert('Your form has been submitted');                } else {                    alert('There was a problem submitting your form');                }            });        });  */    function getActionsId(){        var csv = document.getElementById ("csv");            }        function GetFileInfo () {        var csv = document.getElementById ("csv");        var message = "";        if ('files' in csv) {            if (csv.files.length == 0) {                message = "Please browse for one or more files.";            } else {                for (var i = 0; i < csv.files.length; i++) {                    message += "<br /><b>" + (i+1) + ". file</b><br />";                    var file = csv.files[i];                    if ('name' in file) {                        message += "name: " + file.name + "<br />";                    }                    else {                        message += "name: " + file.fileName + "<br />";                    }                    if ('size' in file) {                        message += "size: " + file.size + " bytes <br />";                    }                    else {                        message += "size: " + file.fileSize + " bytes <br />";                    }                    if ('mediaType' in file) {                        message += "type: " + file.mediaType + "<br />";                    }                }            }        }         else {            if (csv.value == "") {                message += "Please browse for one or more files.";                message += "<br />Use the Control or Shift key for multiple selection.";            }            else {                message += "Your browser doesn't support the files property!";                message += "<br />The path of the selected file: " + csv.value;            }        }        var info = document.getElementById ("info");        info.innerHTML = message;    }    </script></body> </html> 