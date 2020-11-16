<?php
/**
 * contiene métodos que ayudan a mejorar
 * la funcionalidad de los Controller
 * Class ControladorBase
 */

class ControladorBase
{
    public function __construct(){

    }

    /**
     *Esta función permite redireccionar a cualquier página
     * @param string $controlador
     * @param string $accion
     */
    public function redirect($controlador=CONTROLADOR_DEFECTO, $accion=ACCION_DEFECTO){
        header("Location:index.php?controller=".$controlador."&action=".$accion);
    }

    public function test_input($data){
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);

        return $data;
    }
}