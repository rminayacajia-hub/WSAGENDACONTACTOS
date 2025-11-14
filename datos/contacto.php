<?php 
require_once("../datos/model/cls_conexion.php");
header("Content-Type: text/html; charset=utf-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header ('Access-Control-Allow-Headers: Origin, Content-Type, Authorization, Accept, X-Requested-With, x-xsrf-token');
header("Access-Control-Allow-Credentials: true");
$post=json_decode(file_get_contents("php://input"),true)?:$_GET;

// metodo y acccion para consultar datos

if($post['accion']=='consultarDato'){
    $conex=new cls_conexion();
    $conex=$conex->conectar();
    $sentencia=sprintf("SELECT * from contacto
    where cod_contacto='%s'",
    $conex->real_escape_string($post['cod_contacto']));
    $rs=mysqli_query($conex,$sentencia);
    if(mysqli_num_rows($rs)>0)
        {
    
            $row=mysqli_fetch_assoc($rs);    
            $respuesta=json_encode(array("estado"=>true,"contacto"=>$row));
    }
        else{
        $respuesta=json_encode(array("estado"=>false,"mensaje"=>"No existen contactos"));
    }
    echo $respuesta;
}

// metodo y accion para insertar contactos

if($post['accion']=='insertar'){
    $conex=new cls_conexion();
    $conex=$conex->conectar();
    $sentencia=sprintf("INSERT INTO contacto (nom_contacto,ape_contacto,telefono_contacto,email_contacto,persona_cod_persona)
    VALUES ('%s','%s','%s','%s','%s')",
    $conex->real_escape_string($post['nombre']),
    $conex->real_escape_string($post['apellido']),
    $conex->real_escape_string($post['telefono']),
    $conex->real_escape_string($post['email']),
    $conex->real_escape_string($post['cod_persona']));
    $rs=mysqli_query($conex,$sentencia);
    if($rs){
        $respuesta=json_encode(array("estado"=>true,"mensaje"=>"Contacto insertado correctamente"));
    }
    else{
        $respuesta=json_encode(array("estado"=>false,"mensaje"=>"Error al insertar el contacto"));
    }
    echo $respuesta;
}

// metodo y accion para listar contactos

if($post['accion']=='consultar'){
    $conex=new cls_conexion();
    $conex=$conex->conectar();

    $sentencia=sprintf("SELECT * from contacto
    where persona_cod_persona=%s",
    $conex->real_escape_string($post['cod_persona']));
    
    $rs=mysqli_query($conex,$sentencia);

    if(mysqli_num_rows($rs)>0)
        {
        while($row=mysqli_fetch_array($rs))
            {
            $datos[]=array(
        'codigo'=>$row['cod_contacto'],
        'nombre'=>$row['nom_contacto'],
        'apellido'=>$row['ape_contacto']
        );
    }
    $respuesta=json_encode(array("estado"=>true,"personas"=>$datos));
    }
        else{
        $respuesta=json_encode(array("estado"=>false,"mensaje"=>"No existen contactos"));
    }
    echo $respuesta;
}
// metodo y accion para eliminar contactos

if($post['accion']=='eliminar'){
    $conex=new cls_conexion();
    $conex=$conex->conectar();
    $sentencia=sprintf("DELETE from contacto
    where cod_contacto='%s'",
    $conex->real_escape_string($post['cod_contacto']));
    $rs=mysqli_query($conex,$sentencia);
    if($rs){
        $respuesta=json_encode(array("estado"=>true,"mensaje"=>"Contacto eliminado correctamente"));
    }
    else{
        $respuesta=json_encode(array("estado"=>false,"mensaje"=>"Error al eliminar el contacto"));
    }
    echo $respuesta;
}

// metodo y accion para actualizar contactos

if($post['accion']=='actualizar'){
    $conex=new cls_conexion();
    $conex=$conex->conectar();
    $sentencia=sprintf("UPDATE contacto
    set nom_contacto='%s',ape_contacto='%s',telefono_contacto='%s',email_contacto='%s'
    where cod_contacto='%s'",
    $conex->real_escape_string($post['nombre']),
    $conex->real_escape_string($post['apellido']),
    $conex->real_escape_string($post['telefono']),
    $conex->real_escape_string($post['email']),
    $conex->real_escape_string($post['cod_contacto']));
    $rs=mysqli_query($conex,$sentencia);
    if($rs){
        $respuesta=json_encode(array("estado"=>true,"mensaje"=>"Contacto actualizado correctamente"));
    }
    else{
        $respuesta=json_encode(array("estado"=>false,"mensaje"=>"Error al actualizar el contacto"));
    }
    echo $respuesta;
}

?>


