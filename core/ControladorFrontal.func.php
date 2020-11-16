<?php
/**
 * Created by PhpStorm.
 * User: alopezorozco
 * Date: 05/09/2020
 * Time: 08:10 AM
 *
 * Ahora crearemos el fichero ControladorFrontal.func.php que
 * tiene las funciones que se encargan de cargar un controlador u
 * otro y una acción u otra en función de lo que se le diga por la url.
 */

//FUNCIONES PARA EL CONTROLADOR FRONTAL

function cargarControlador($controller){
    //ucwords convierte la primera letra mayúscula de un String
    $controlador=ucwords($controller).'Controller';
    $strFileController='controller/'.$controlador.'.php';



    if(!is_file($strFileController)){
        $strFileController='controller/'.ucwords(CONTROLADOR_DEFECTO).'Controller.php';
    }

    require_once $strFileController;
    $controllerObj=new $controlador();
    return $controllerObj;
}

function cargarAccion($controllerObj, $action){
    $accion=$action;
    $controllerObj->$accion();
}

//si se han
function lanzarAccion($controllerObj){
    if(isset($_GET["action"]) && method_exists($controllerObj, $_GET["action"])){
        cargarAccion($controllerObj, $_GET["action"]);
    }else{
        cargarAccion($controllerObj, ACCION_DEFECTO);
    }
}
?>