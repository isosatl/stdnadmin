<?php 		    //Script para determinar si se ha iniciado sessión y si es administrador.    if (session_id() == ''){        session_start();                    if (isset($_SESSION['privilegios'])){            if ($_SESSION['privilegios'] == 'admin'){                //mostrar contenido que corresponda a administrador                //print_r($_SESSION['privilegios']);                            }        }    }    if (!isset($_SESSION['usuario']) || (!isset($_SESSION['clave']))) {        $_SESSION['violation'] = 1;        header('Location: ./login.php');        exit();    } if (isset($_SESSION['timeout'])) {        $sessionTTL = time() - $_SESSION['timeout'];        if ($sessionTTL > $_SESSION['tiempoLimite']) {            $_SESSION['logedout'] = 1;            header('Location: ./login.php');            exit();        }    }    $_SESSION['timeout'] = time();    print_r($_SESSION);    include ROOT_DIR . '/includes/header.php';				    include ROOT_DIR . '/includes/nav.php';		?>    <link rel="stylesheet" type="text/css" href="themes/empty/css/bootstrap.css" />	        <body id="cursos">    <div class="CursosTableContainer"><script type="text/javascript">        $(document).ready(function () {        $('.CursosTableContainer').jtable({        	paging: true,        	pageSize: 8,        	sorting: true,        	defaultSorting: 'nombre_d_curso ASC',        	selecting: true,        	multiselect: true,        	selectingCheckboxes: true,        	selectOnRowClick: false,                        title: 'Formulario de cursos',            actions: {                listAction: 'dbInterfaces/CursosActions.php?action=list',                createAction: 'dbInterfaces/CursosActions.php?action=create',                updateAction: 'dbInterfaces/CursosActions.php?action=update',                deleteAction: 'dbInterfaces/CursosActions.php?action=delete'            },            fields: {   	            id_cursos: {                    title: 'Id del curso',   		            key: true,       		        create: false,           		    edit: false,               		list: true,                    width: '15%'               	},	  				nombre_d_curso: {	   	           	title: 'Curso',  					create: true,  					edit: true,  					list: true,           	    	width: '60%'               	},               	unidades_del_curso: {	           		title: 'Unidades',  					create: true,  					edit: true,  					list: true,              		width: '10px'              	},	       	},			selectionChanged: function(){        		var $selectedRows = $('.CursosTableContainer').jtable('selectedRows');        		$('#SelectedRowList').empty();        		if($selectedRows.length > 0){        			$selectedRows.each(function(){        				var record = $(this).data('record');        				$('#SelectedRowList').append(        					'id_cursos:' + record.id_cursos + 'nombre_d_curso:' + record.nombre_d_curso        				);        			});        		}else{        			$('#SelectedRowList').append('No row selected!');        		}        	}            		});		$('.CursosTableContainer').jtable('load');   				});        $(document).ready(function(){    $('table.jtable').css({'width':'700px', 'position':'relative', 'left':'145px'});    $('.jtable-title').css({'width':'698px', 'position':'relative', 'left':'143px'});    $('.jtable-bottom-panel').css({'width':'698px', 'position':'relative', 'left':'145px'});    //$('table.jtable').offset({top: 10, left: 30});    });    </script>	    </div>    <div id="footer_container"></div>	</body></html>