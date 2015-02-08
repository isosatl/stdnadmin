<?php

/**
 * Description of commonPurposes
 * Esta clase contiene funciones que proveen utilidades generales
 * @author Isaias
 */
class commonPurposes {    
    /*
     * Esta función imprime mensajes de errores o advertencias.
     */
    public function errorMessage($error) {
        $err = $error;
        switch ($err) {
            case 'logedout':
                echo '<p class="Mensaje">Su sesión ha expirado, ingrese de nuevo!</p>';
                break;
            case 'loginerror':
                echo '<p class="Mensaje">Corrija sus datos o consulte con su administrador!</p>';
                break;
            case 'violation':
                echo '<p class="Mensaje">Solicite una cuenta para ingresar!</p>';
                break;
            default:
                echo '<p class="Mensaje">Página con errores</p>';
                break;
        }
    }

}

?>
