<?php


class Empleado
{
    private $id;
    private $emp_nombre;
    private $emp_apellido_paterno;

    //constructor
    public function __construct(){
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getEmpNombre()
    {
         return $this->emp_nombre;
    }

    /**
     * @param mixed $emp_nombre
     */
    public function setEmpNombre($emp_nombre)
    {
      /*if (empty($emp_nombre)){
           throw new Exception("escribe el nombre del empleado");
       }else{
          $emp_nombre = mb_strtoupper($emp_nombre, 'utf-8');
          if (!ctype_alpha(str_replace(' ','', $this->clearSpanishCaracteres($emp_nombre)))){
             throw new Exception("El nombre debe contenter sólo letras");
          }else {*/
              $this->emp_nombre = strtoupper($emp_nombre);
          //}
       //}
    }

    /**
     * @return mixed
     */
    public function getEmpApellidoPaterno()
    {
        return $this->emp_apellido_paterno;
    }

    /**
     * @param mixed $emp_apellido_paterno
     */
    public function setEmpApellidoPaterno($emp_apellido_paterno)
    {
        /*if (empty($emp_apellido_paterno)){
            throw new Exception("Escribe el apellido del empleado");
        }else {
            $emp_apellido_paterno = mb_strtoupper($emp_apellido_paterno, 'utf-8');
            if (!ctype_alpha($this->clearSpanishCaracteres($emp_apellido_paterno))){
                throw new Exception("El apellido paterno debe contenter sólo letras sin espacios en blanco");
            }else {*/
                $this->emp_apellido_paterno = strtoupper($emp_apellido_paterno);
        //    }
        //}
    }

    private function clearSpanishCaracteres($data){
        $data = str_replace('Á','', $data);
        $data = str_replace('É','', $data);
        $data = str_replace('Í','', $data);
        $data = str_replace('Ó','', $data);
        $data = str_replace('Ú','', $data);
        $data = str_replace('Ñ','', $data);

        $data = str_replace('á','', $data);
        $data = str_replace('é','', $data);
        $data = str_replace('í','', $data);
        $data = str_replace('ó','', $data);
        $data = str_replace('ú','', $data);
        $data = str_replace('ñ','', $data);

        return $data;
    }
}