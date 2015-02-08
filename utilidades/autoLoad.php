<?php

/* Description of autoLoad
 * @author Isaias
 * Esta función realiza lo que su nombre dice:
 * Cargar las clases que se encuentran en cada uno de los directorios 
 * incluídos en el array
 */
function __autoload($classname) { 
    $possibilities = array( 
        APPLICATION_PATH.'utilidades'.DIRECTORY_SEPARATOR.$classname.'.php', 
        $classname.'.php' 
    );
    foreach ($possibilities as $file) { 
        if (file_exists($file)) { 
            require_once($file); 
            return true; 
        } 
    } 
    return false;     
} 

?>
