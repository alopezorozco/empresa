<?php

//Configuración global
require_once 'config/global.php';

//Core de la aplicación
require_once 'core/ControladorFrontal.func.php';

//cargamos controladores y acciones
if (isset($_GET["controller"])){
    $controlerObj = cargarControlador($_GET["controller"]);
    lanzarAccion($controlerObj);
}else{
    $controlerObj=cargarControlador(CONTROLADOR_DEFECTO);
    lanzarAccion($controlerObj);
}