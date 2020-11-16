<?php

//accedemos a las dependencias de Twig
require_once './vendor/autoload.php';

//accedemos a la clase EmpleadoModel para realizar operaciones a la base de datos
require_once './model/EmpleadoModel.php';
require_once './model/CategoriaModel.php';
require_once './core/ControladorBase.php';

class EmpleadoController
{
    private $loader;
    private $twig;
    private $controladorBase;


    public function __construct(){
        $this->controladorBase = new ControladorBase();

        $this->loader = new \Twig\Loader\FilesystemLoader('./view');
        $this->twig = new \Twig\Environment($this->loader);
    }

    /**
     * Muestra la página principal y el listado de empleados dados de alta
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function index(){
        //creamos un objeto de tipo EmpleadoModel
        $empleado = new EmpleadoModel();

        $categoria = new CategoriaModel();

        //obtenemos la lista de empleados
        $listaDeEmpleados = $empleado->getAll();

        $listaDeCategorias = $categoria->getAll();

        var_dump($listaDeCategorias);

        //mostramos la página con la lista de empleados
        echo $this->twig->render('/empleado/index.html.twig', compact('listaDeEmpleados'));
    }

    /**
     * permite eliminar un empleado
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function delete(){
        $empleadoAEliminar = "";

        //si existe en la url el id pero no existe la variable confirmacion mostramos los datos a eliminar
        if (isset($_GET["id"])&&(!isset($_GET["confirmation"]))){
            $id = $_GET["id"];

            $empleado = new EmpleadoModel();

            //obtenemos los datos de este empleado que es un objeto
            $empleadoAEliminar = $empleado->getById($id);

            //mostramos los datos en pantalla
            echo $this->twig->render('/empleado/eliminar.html.twig', compact('empleadoAEliminar'));
        }else{
            if (isset($_GET["id"])&&(isset($_GET["confirmation"]))){ //si existe el id y la variable confirmación procedemos a eliminar el empleado
                $id = $_GET['id'];
                $confirmation = $_GET['confirmation'];

                if ($confirmation=="ok"){
                    //creamos el objeto
                    $empleado = new EmpleadoModel();

                    //llamamos al metodo eliminar
                    $result = $empleado->deleteById($id);

                    if ($result){
                        $this->controladorBase->redirect("empleado","index");
                    }else{
                        $mensaje = ["mensaje"=>"No se pudo eliminar el empleado"];
                        echo $this->twig->render('error.html.twig', compact('mensaje'));
                    }
                }//fin del if de confirmacion
            }//fin del if
        }
    }//fin del método eliminar

    /**
     * permite insertar un nuevo registro en la tabla empleados
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function save(){
        //variables para almacenar los datos
        //ejemplo completo de formulario https://tryphp.w3schools.com/showphp.php?filename=demo_form_validation_complete
        $nombre = $apellido = "";

        if ($_SERVER["REQUEST_METHOD"] == "POST"){ //si los datos han sido enviados se procesan para guardarlos en la entidad empleado
            try {
                $nombre = $this->controladorBase->test_input($_POST["empnombre"]);
                $apellido = $this->controladorBase->test_input($_POST["empape"]);


                //creamos el objeto empleado
                $empleado = new Empleado();

                $empleado->setEmpNombre($nombre);
                $empleado->setEmpApellidoPaterno($apellido);

                //creamos un objeto del tipo EmpleadoModel
                $empleadoModel = new EmpleadoModel();


                //llamamos al método save
                $result = $empleadoModel->save($empleado);

                //si la operación fue correcta
                if ($result) {
                    $this->controladorBase->redirect("empleado", "index");
                } else {
                    $mensaje = "No se pudo insertar el nuevo empleado";
                    echo $this->twig->render('error.html.twig', compact('mensaje'));
                }
            }catch(Exception $e){
                $mensaje = $e->getMessage();
                echo $this->twig->render('error.html.twig', compact('mensaje'));
            }
        }else{ //si no se han enviado datos a través del post mostramos el formulario de captura
            echo $this->twig->render('/empleado/insertar.html.twig');
        }
    }//fin del método

    /**
     * permite actualizar la tabla empleados
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function update(){
        $empleadoAModificar = null;

        if ($_SERVER["REQUEST_METHOD"] == "POST"){ //si se han enviado los datos procedemos a actualizar el empleado
            try {
                //obtenemos los datos del formulario
                $id = $_POST["id"];
                $nombre = $this->controladorBase->test_input($_POST["empnombre"]);
                $apellido = $this->controladorBase->test_input($_POST["empape"]);

                //creamos un objeto de tipo empleado
                $empleado = new Empleado();

                $empleado->setId($id);
                $empleado->setEmpNombre($nombre);
                $empleado->setEmpApellidoPaterno($apellido);

                //creamos un objeto de tipo EmpleadoModel

                $empleadoModel = new EmpleadoModel();

                $result = $empleadoModel->update($empleado);

                if ($result) {
                    $this->controladorBase->redirect("empleado", "index");
                } else {
                    $mensaje = "No se pudieron efectuar los cambios";
                    echo $this->twig->render('error.html.twig', compact('mensaje'));
                }
            }catch(Exception $e){
                $mensaje = $e->getMessage();
                echo $this->twig->render('error.html.twig', compact('mensaje'));
            }
        }else{ //sino se han enviado datos a través del post mostramos el formulario con los datos del empleado a modificar
            //obtenemos el id
            $id = $_GET["id"];

            //creamos un objeto de tipo Empleado
            $empleado = new EmpleadoModel();

            //obtenemos los datos del empleado que es un objeto
            $empleadoAModificar = $empleado->getById($id);

            if ($empleadoAModificar){
                echo $this->twig->render('/empleado/editar.html.twig', compact('empleadoAModificar'));
            }else{
                $mensaje = "El Id. del Empleado no existe";
                echo $this->twig->render('error.html.twig',compact('mensaje'));
            }
        }
    }
}