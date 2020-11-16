<?php
class Conectar{
    //definición de campos
    private static $driver = 'mysql';
    private static $host = 'localhost';
    private static $user = 'root';
    private static $pass = '';
    private static $database = 'empresa';
    private static $charset = 'utf8';

    //constructor que asigna los datos de conexion a la bd
    public function __construct(){

    }


    /**
     * crea una conexión a la bd
     * @return PDO|null
     */
    public static function conexion(){
        $conn = null;
        if ($conn == NULL ) {
            try {
                $conn = new PDO ("mysql:host=".self::$host.";dbname=".self::$database.";charset=".self::$charset.";", self::$user,self::$pass);
                //$conn = new PDO("mysql:host=$this->host;dbname=$this->database;charset=$this->charset", $this->user, $this->pass);
                //establecemos el modo de manejo de errores y excepciones
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            } catch (PDOException $e) {
                echo "Connection failed: " . $e->getMessage();
            }
        }

        return $conn;
    }


}
?>