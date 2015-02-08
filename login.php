<?php

    //Sentencia para determinar si se ha iniciado sessión y si es administrador.
    if (session_id() == ''){
        session_start();            
    }
    
    require_once 'init.php';
    require_once 'utilidades/autoLoad.php';
    $msg = new commonPurposes();    
    if (isset($_SESSION['logedout']) == 1 ){
        $msg->errorMessage('logedout');
    }else if (isset($_SESSION['loginerror']) == 1){
        $msg->errorMessage('loginerror');        
    }else if (isset($_SESSION['violation']) == 1){
        $msg->errorMessage('violation');
    }
    print_r($_SESSION);
    $_SESSION = Array();
    session_destroy();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Registración</title>    
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />        
    <link rel="stylesheet" type="text/css" href="themes/empty/css/bootstrap.css" />	        
</head>

<body style="margin-top: 185px;">
    <section id="forms">
        <div class="row">
            <div class="span7 offset3">
                <div>
                    <!--<div style="display: none;" class="noRegistrado"><p>Corrija sus datos, o consulte con el administrador</p></div>-->
                    <p style="display: none;">Aún no está registrado!&nbsp;&nbsp;&nbsp;<a id="btn" class="btn btn-primary btn-small">Solicite una cuenta</a></p>
                </div>
                <form action="dbInterfaces/inicioActions.php" class="form-horizontal well" name="frm" id="registerHere">
                    <fieldset>
                        <legend>Ingrese sus credenciales por favor</legend>
                        <div class="control-group">
                            <label class="control-label" for="user_email">Usuario</label>
                            <div class="controls">
                                <label class="input">
                                    <input type="text" class="input-xlarge" id="user_email" name="user_email" rel="popover" data-content="¿Cuál es su correo electrónico?" data-original-title="Email" >
                                </label>
                            </div>
                            <label style="clear: left;" class="control-label" for="pwd">Clave</label>
                            <div class="controls">
                                <label class="input">
                                    <input type="password" class="input-xlarge" id="pwd" name="pwd" rel="popover" data-content="La clave debe ser de 6 caracteres o más" data-original-title="Password" >
                                </label>
                                <button type="submit" class="btn" onblur="getUid(this.form);">Ingresar</button>
                            </div>
                        </div>
                    </fieldset>                        
                </form>
            </div>
        </div>        
    </section>

    
    <div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
            <h4>Registro de usuarios</h4>
        </div>
        <div class="modal-body">
            <form class="form-horizontal" id="registerHere" method='post' action=''>
                <fieldset>
                    <div class="control-group">
                        <label class="control-label" for="input01">Name</label>
                        <div class="controls">
                            <input type="text" class="input-xlarge" id="user_name" name="user_name" rel="popover" data-content="Enter your first and last name." data-original-title="Full Name">                                
                        </div>
                    </div>
                        
                    <div class="control-group">
                        <label class="control-label" for="input01">Email</label>
                        <div class="controls">
                            <input type="text" class="input-xlarge" id="user_email" name="user_email" rel="popover" data-content="What’s your email address?" data-original-title="Email">                                
                        </div>
                    </div>
                        
                    <div class="control-group">
                        <label class="control-label" for="input01">Password</label>
                        <div class="controls">
                            <input type="password" class="input-xlarge" id="pwd" name="pwd" rel="popover" data-content="6 characters or more! Be tricky" data-original-title="Password" >                                
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="input01">Confirm Password</label>
                        <div class="controls">
                            <input type="password" class="input-xlarge" id="cpwd" name="cpwd" rel="popover" data-content="Re-enter your password for confirmation." data-original-title="Re-Password" >                                
                        </div>
                    </div>
                        
                    <div class="control-group">
                        <label class="control-label" for="input01">Gender</label>
                        <div class="controls">
                            <select name="gender" id="gender" >
                                <option value="">Gender</option>
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                            </select>
                        </div>
                    </div>                        
                </fieldset>
            </form>                
        </div>    
        
        <div class="modal-footer">
            <div class="control-group">
                <label class="control-label" for="input01"></label>
                <div class="controls">        
                    <a id="modal-form-submit" class="btn btn-success" href="#">Guardar datos</a>
                    <button class="btn" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript" src="scripts/jQuery.js"></script>    
    <script type="text/javascript" src="scripts/js/bootstrap-alert.js"></script>
    <script type="text/javascript" src="scripts/js/bootstrap-tooltip.js"></script>
    <script type="text/javascript" src="scripts/js/bootstrap-popover.js"></script>
    <script type="text/javascript" src="scripts/js/bootstrap-modal.js"></script>
    <script type="text/javascript" src="http://jzaefferer.github.com/jquery-validation/jquery.validate.js"></script>

    <script type="text/javascript">
    
    $(document).ready(function(){
        //$('.btn-primary').parent().hide();
        $('.Mensaje').appendTo('#registerHere');
        $('.Mensaje').css({"color": "red", "text-align": "center"});
            
    });
    //Crerar nuevo usuario
    //$('#btn').bind('click', function(e){
    //    $('#myModal').modal('show')
    //});
    
    //Guardar nuevo usuario
    $('#modal-form-submit').on('click', function(e){
       e.preventDefault();
       $('#registerHere').submit();
    });
    
    //Validación de campos y tooltips
    $(document).ready(function(){
        $('input').hover(function(){
            $(this).popover('show')
        });
        $('input').mouseout(function(){
           $(this) .popover('hide')
        });        
        $("#registerHere").validate({
            rules:{
                user_name:"required",
                user_email:{
                    required:true,
                    email: true
                },
                pwd:{
                    required:true,
                    minlength: 6
                },
                cpwd:{
                    required:true,
                    equalTo: "#pwd"
                },
                gender:"required"
            },
            messages:{
                user_name:"Enter your first and last name",
                user_email:{
                    required:"Enter your email address",
                    email:"Enter valid email address"
                },
                pwd:{
                    required:"Enter your password",
                    minlength:"Password must be minimum 6 characters"
                },
                cpwd:{
                    required:"Enter confirm password",
                    equalTo:"Password and Confirm Password must match"
                },
                gender:"Select Gender"
            },
            errorClass: "help-inline",
            errorElement: "span",
            highlight:function(element, errorClass, validClass) {
                $(element).parents('.control-group').addClass('error');
            },
            unhighlight: function(element, errorClass, validClass) {
                $(element).parents('.control-group').removeClass('error');
                $(element).parents('.control-group').addClass('success');
            }
        });
    });
    
    function getUid(){
        var nombreU = frm.elements["user_email"].value;
        var claveU = frm.elements["pwd"].value;
        return true;
    }        
    </script>

</body>
</html>