/* 
 * Este archivo contiene funciones utilizadas
 * en la página InformeAlumnos.php
 */
    
    /*Desabilita la tecla enter en el input con id service*/
    $(function () {
        $('#service').keypress(function (e) {
            var code = null;
            code = (e.keyCode ? e.keyCode : e.which);
            return (code == 13) ? false : true;
        });
    });
    
    //función para obtener el valor de cada radio seleccionado        
    function getRadioValue(){
        for (var i = 0; i < document.getElementsByName('filtrar').length; i++){
            if (document.getElementsByName('filtrar')[i].checked){
                return document.getElementsByName('filtrar')[i].value;
            }else{
                return 0;
            }
        }
    }
    
    /* Desabilitar radio buttons cuando se busque por alumno*/
    function DesabilRadios(){
        jQuery("input[name='filtrar']").each(function(i){
            if (jQuery(this).attr('disabled', false)){
                jQuery(this).attr('disabled', 'disabled');           
            }                   
        });
    }

    /* habilitar radio buttons cuando la búsqueda no sea por alumno*/
    function habilRadios(){
        jQuery("input[name='filtrar']").each(function(i){
            if (jQuery(this).attr('disabled', true)){
                jQuery(this).attr('disabled', false);           
            }                
        });                    
    }
    
    /* función que indú­ca que algo estú¡ desabilitado*/
    function opacarOpcion(opt){
        if (opt == 'input' || opt  == 'service' ){
        DesabilRadios();        
        $('#service').css("opacity","100");
        $('.boton').css("opacity","100");
        $('#select-secc').css("opacity",".50");
        $('#select_carr').css("opacity",".50");
        $('#select_grd').css("opacity",".50"); 
       }else if (opt == 1){
        habilRadios();
        $('#select-secc').css("opacity","100");
        $('#select_carr').css("opacity",".50");
        $('#select_grd').css("opacity",".50"); 
        $('#service').css("opacity",".50");       
        $('.boton').css("opacity",".10");
       }else if (opt == 2 || opt == 3){
        habilRadios();
        $('#select-secc').css("opacity",".50");
        $('#select_carr').css("opacity","100");
        $('#select_grd').css("opacity","100"); 
        $('#service').css("opacity",".50");                       
        $('.boton').css("opacity",".10");
       }
    }
    
    /* función para limpiar elementos con propiedad input*/
    function limpiarElementos(elementos){
        $(elementos).find(':input').each(function(){
            switch(this.type){
                case 'password':
                case 'select-multiple':
                case 'select-one':
                case 'text':
                case 'textarea':
                    $(this).val('');
                    break;
                case 'checkbox':
                case 'radio':
                    this.checked = false;
            }
        });
    }

    //pobla el listBox de secciones
    function fillSecciones(){
        $.ajax({
            type: "POST",
            dataType: "json",
            data: '',
            url: "dbInterfaces/InfAlumnosActions.php?action=fillseccBox",
            success: function(data, textStatus, jqXHR){
                var options = '';
                for (var i = 0; i < data.length; i++){
                    options += '<option value="' + data[i].id_secciones + '">' + data[i].nombre_d_seccion + '</option>';            
                }
                $("#select-secc").fadeIn('fast').append(options);           
            },
            error: function (response, request, error) {
                    $("#error").append("<option value=\"0\">No se encontró ningún dato</option>");                                  
            },
        });
    }
               
    //función que muestra la información de los alumnos al seleccionar un radio 
    function mostrarAlumnosInfo(){
        var id_secciones = document.getElementById('select-secc').value;
        //var id_filtro = getRadioValue();
        var id_filtro = $('input[name=filtrar]:checked', '#frm').val();
        console.log('el id del filtro es: ', id_filtro);
        $('#T_secciones').fadeOut('fast').empty();
        $.ajax({
            type: 'POST',
            dataType: 'json',
            data: '',
            async: true,
            url: "dbInterfaces/InfAlumnosActions.php?action=infAlumnos&id_secciones=" + id_secciones + "& id_filtro=" + id_filtro,
            beforeSend: function(xhr){
                xhr.setRequestHeader("Accept", "text/javascript");
                $('#info').html('<img src="img/ajax-loader.gif" />');
            },
            success: function(data){
                var options = '';
                $('#T_secciones').append(encabezado);
                //$('#id_encabezado* td').css({'color': '#2E5257', 'font-size': 18,'background-color':'#99DED1'});
                $('.encabezado* td').css({'font-family':'Verdana','font-size':'12px','font-weight':'bold','background':'url(img/header-bg.gif) left','color':'#CFDCE7'});
                for(var i = 0; i < data.length; i++){
                    var content = ' ';
                    content += '<tr class="contenido"><td>' +  data[i].id_alumnos  + '</td>';
                    content += '<td>' +  data[i].id_a_secciones  + '</td>';
                    content += '<td>' +  data[i].id_a_grados  + '</td>';
                    content += '<td>' +  data[i].id_a_carreras  + '</td>';
                    content += '<td id="izquierda">' +  data[i].nombres_alumnos  + '</td>';
                    content += '<td id="izquierda">' +  data[i].apellidos_alumnos  + '</td>';
                    content += '<td>' +  data[i].genero  + '</td>';
                    content += '<td>' +  data[i].edad  + '</td></tr>';
                    $('#T_secciones').fadeIn('fast').append(content);
                    $('.contenido* td').css({'font-family':'Verdana', 'font-size': 13, 'text-align':'center','font-color':'black'});
                    $('.contenido #izquierda').css({'text-align':'left'});
                }
            },              
            complete: function () {
                $('#info').empty();
                $('#error').empty();
                $("#select-secc").focus();
            },
        });         
    }

    //muestra los alumnos al seleccionar un grado
    function mostrarAlumnosPorGrado(){
        var id_carreras = document.getElementById('select_carr').value;
        var id_grados = document.getElementById('select_grd').value;        
        //var id_filtro = getRadioValue();
        var id_filtro = $('input[name=filtrar]:checked', '#frm').val();
        $('#T_secciones').fadeOut('fast').empty();
        console.log("id_carreras: " + id_carreras + " " + "id_grados: " + id_grados);
        $.ajax({
            type: 'POST',
            dataType: 'json',
            data: '',
            url: "dbInterfaces/InfAlumnosActions.php?action=infAlumnosPorgrd&id_carreras=" + id_carreras + "& id_grados=" + id_grados + "& id_filtro=" + id_filtro,
            beforeSend: function(xhr){
                xhr.setRequestHeader("Accept", "text/javascript");
                $('#info').html('<img src="img/ajax-loader.gif" />');
            },
            success: function(data, textStatus, jqXHR){
                var options = '';
                $('#T_secciones').append(encabezado);
                //$('#id_encabezado* td').css({'color': '#2E5257', 'font-size': 18,'background-color':'#99DED1'});
                $('.encabezado* td').css({'font-family':'Verdana','font-size':'12px','font-weight':'bold','background':'url(img/header-bg.gif) left','color':'#CFDCE7'});                
                for(var i = 0; i < data.length; i++){
                    var content = ' ';
                    content += '<tr class="contenido"><td>' +  data[i].id_alumnos  + '</td>';
                    content += '<td>' +  data[i].id_a_secciones  + '</td>';
                    content += '<td>' +  data[i].id_a_grados  + '</td>';
                    content += '<td>' +  data[i].id_a_carreras  + '</td>';
                    content += '<td id="izquierda">' +  data[i].nombres_alumnos  + '</td>';
                    content += '<td id="izquierda">' +  data[i].apellidos_alumnos  + '</td>';
                    content += '<td>' +  data[i].genero  + '</td>';
                    content += '<td>' +  data[i].edad  + '</td></tr>';
                    $('#T_secciones').fadeIn('fast').append(content);
                    $('.contenido* td').css({'font-family':'Verdana', 'font-size': 13, 'text-align':'center','font-color':'black'});
                    $('.contenido #izquierda').css({'text-align':'left'});
                }
            },             
            complete: function(objeto, exito){
                if(exito == "success"){
                    $('#info').empty();
                }
            console.log("Probando el filtro con: " + id_filtro);
            }
    });}

    //función que muestra la información de un alumno
    function mostrarAlumno(alumno){
    $('#T_secciones').empty().fadeOut('fast');
        $.ajax({
            type: 'POST',
            dataType: 'json',
            data: '',
            url: "dbInterfaces/InfAlumnosActions.php?action=infAlumno&alumno=" + alumno,
            success: function(data, textStatus, jqXHR){
                var options = '';
                $('#T_secciones').append(encabezado);
                //$('#id_encabezado* td').css({'color': '#2E5257', 'font-size': 18,'background-color':'#99DED1'});
                $('.encabezado* td').css({'font-family':'Verdana','font-size':'12px','font-weight':'bold','background':'url(img/header-bg.gif) left','color':'#CFDCE7'});                
                for(var i = 0; i < data.length; i++){
                    var content = ' ';
                    content += '<tr class="contenido"><td>' +  data[i].id_alumnos  + '</td>';
                    content += '<td>' +  data[i].id_a_secciones  + '</td>';
                    content += '<td>' +  data[i].id_a_grados  + '</td>';
                    content += '<td>' +  data[i].id_a_carreras  + '</td>';
                    content += '<td id="izquierda">' +  data[i].nombres_alumnos  + '</td>';
                    content += '<td id="izquierda">' +  data[i].apellidos_alumnos  + '</td>';
                    content += '<td>' +  data[i].genero  + '</td>';
                    content += '<td>' +  data[i].edad  + '</td></tr>';
                    $('#T_secciones').fadeIn('fast').append(content);
                    $('.contenido* td').css({'font-family':'Verdana', 'font-size': 13, 'text-align':'center','font-color':'black'});
                    $('.contenido #izquierda').css({'text-align':'left'});
                }
            },              
        });         
    }

    /* acción de auto completado*/
    function buscarAlumno(){
    //Al escribr dentro del input con id="service"                
    //Obtenemos el value del input
        var service = $(this).val();        
        var dataString = 'service='+service;        
        //Le pasamos el valor del input al ajax
        $.ajax({
            type: "POST",
            url: "dbInterfaces/InfAlumnosActions.php?action=autoCompletado",
            data: dataString,
            cache: false,
            success: function(data) {                    
                //Escribimos las sugerencias que nos manda la consulta
                $('#suggestions').slideDown(1000).html(data);
                //Al hacer click en algua de las sugerencias
                $('.suggest-element').live('click', function(){
                    //Obtenemos la id unica de la sugerencia pulsada
                    var id = $(this).attr('id');
                    //Editamos el valor del input con data de la sugerencia pulsada
                    $('#service').val($('#'+id).attr('data'));
                    $('#suggestions').slideUp(1000);
                    //var aszTemp = (this.tagName).toLowerCase()
                    //opacarOpcion(aszTemp);
                });              
            }
        });
    }

    /* poblar unidades*/
    function poblarUnidades(){
        $.ajax({
            type: "POST",
            dataType: "json",
            data: '',
            url: "dbInterfaces/InformeNotasActions.php?action=poblarUnidadesBox",
            beforeSend: function(xhr){
                xhr.setRequestHeader("Accept", "text/javascript");
                $('#info').html('<img src="img/ajax-loader.gif" />');
            },
            complete: function () {
                $('#info').empty();
                //$('#error').empty();
                //$("#select-secc").focus();
            },
            success: function(data, textStatus, jqXHR){
                var options = '';
                for (var i = 0; i < data.length; i++){
                    options += '<option value="' + data[i].id_unidades + '">' + data[i].nombre_de_unidad + '</option>';
                }
                $("#select-unidades").fadeIn('fast').append(options);           
            },
            error: function (response, request, error) {
                $("#error").append("<option value=\"0\">No se encontró ningún dato</option>");                                  
            },
        });
    }

