<?php
require_once '../Config/config.php';
class Cls_conexion
{
    public $conexion;
    public function conectar()
    {
        $this->conexion=mysqli_connect(host,usuario,clave,db); 
        if(!$this->conexion) die ("error de conexion con mysql");
        mysqli_set_charset($this->conexion,'utf8');
        return $this->conexion;
    }
}
?>

