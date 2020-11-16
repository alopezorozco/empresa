<?php

//accedemos a las dependencias de Twig
require_once './vendor/autoload.php';

class indexController
{
    private $loader;
    private $twig;


    public function __construct(){
        $this->loader = new \Twig\Loader\FilesystemLoader('./view');
        $this->twig = new \Twig\Environment($this->loader);
    }

    public function index(){
        echo $this->twig->render('index.html.twig');
    }
}