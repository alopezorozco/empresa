<?php
require_once './config/conectar.php';

class CategoriaModel
{
    //campo para la conexión a la bd
    private $conn;

    public function __construct(){
        //creamos la conexión a la bd
        $this->conn = conectar::conexion();
    }

    public function getAll(){
        try{
            $stmt = $this->conn->prepare("SELECT * FROM categoria ORDER BY id DESC");
            $stmt->execute();

            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }catch(PDOException $e){
            echo "Error: ".$e->getMessage();
        }

        $this->conn = null;
        return $result;
    }
}