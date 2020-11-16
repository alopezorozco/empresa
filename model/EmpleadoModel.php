<?php
require_once './config/conectar.php';
require_once 'Empleado.php';


class EmpleadoModel
{
    //campo para la conexión a la bd
    private $conn;

    public function __construct(){
        $this->conn = conectar::conexion();
    }

    /**
     * retornamos la lista de todos los empleados
     * @return array
     */
    public function getAll(){
        try{
            $stmt = $this->conn->prepare("SELECT id, emp_nombre, emp_apellido_paterno FROM empleado ORDER BY id DESC");
            $stmt->execute();

            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }catch(PDOException $e){
            echo "Error: ".$e->getMessage();
        }

        //$this->conn = null;
        return $result;
    }

    /**
     * Retorna los datos de un empleado
     * @param $id
     * @return mixed
     */
    public function getById($id){
        try{
            $stmt = $this->conn->prepare("SELECT * FROM empleado WHERE id=:id");
            $stmt->bindParam(":id", $id);
            $stmt->execute();

            $result =  $stmt->fetchObject('Empleado');
        }catch(PDOException $e){
            echo "Error: ".$e->getMessage();
        }

        $stmt = null;
        $this->conn = null;
        return $result;
    }

    /**
     * elimina un empleado basandose en el id
     * @param $id
     * @return bool
     */
    public function deleteById($id){
        try{
            $stmt = $this->conn->prepare("DELETE FROM empleado WHERE id=:id");
            $stmt->bindParam(":id", $id);

            $result = $stmt->execute();
        }catch(PDOException $e){
            echo "Error: ".$e->getMessage();
        }

        return $result;
    }

    /**
     * Guarda un registro de empleado en la tabla correspondiente
     * @param $empleado //objeto empleado
     * @return bool
     */
    public function save($empleado){
        $result = false;
        try{
            //pasamos los datos del objeto a variables
            $nombre = $empleado->getEmpNombre();
            $apellido = $empleado->getEmpApellidoPaterno();

            $stmt = $this->conn->prepare("INSERT INTO empleado (emp_nombre, emp_apellido_paterno) VALUES (:emp_nombre, :emp_apellido_paterno)");
            $stmt->bindParam(":emp_nombre", $nombre);
            $stmt->bindParam(":emp_apellido_paterno", $apellido);

            $result= $stmt->execute();

            return $result;
       }catch(PDOException $e){
            echo "Error: ".$e->getMessage();
        }

        $stmt = null;
        $this->conn = null;
        return $result;
    }

    public function update($empleado){
        $result = false;
        try{
            //pasamos los datos del objeto a variables
            $id = $empleado->getId();
            $nombre = $empleado->getEmpNombre();
            $apellido = $empleado->getEmpApellidoPaterno();

            $stmt = $this->conn->prepare("UPDATE empleado SET emp_nombre=:emp_nombre, emp_apellido_paterno=:emp_apellido WHERE id=:id");
            $stmt->bindParam(":emp_nombre", $nombre);
            $stmt->bindParam(":emp_apellido", $apellido);
            $stmt->bindParam(":id",$id);

            $result= $stmt->execute();

            var_dump($result);
            return $result;
        }catch(PDOException $e){
            echo "Error: ".$e->getMessage();
        }

        $stmt = null;
        $this->conn = null;
        return $result;
    }
}//fin de la clase Empleado