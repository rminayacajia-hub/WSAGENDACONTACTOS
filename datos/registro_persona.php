<?php
require_once("../datos/model/cls_conexion.php");
header("Content-Type: text/html; charset=utf-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header ('Access-Control-Allow-Headers: Origin, Content-Type, Authorization, Accept, X-Requested-With, x-xsrf-token');
header("Access-Control-Allow-Credentials: true");

$post = json_decode(file_get_contents("php://input"), true) ?: $_GET;

// metodo y accion para insertar persona

if ($post['accion'] == 'insertar') {
    $conex = new cls_conexion();
    $conex = $conex->conectar();

    $sentencia = sprintf(
        "INSERT INTO persona (ci_persona, nom_persona, ape_persona, clave_persona, correo_persona)
        VALUES ('%s','%s','%s','%s','%s')",
        $conex->real_escape_string($post['ci_persona']),
        $conex->real_escape_string($post['nom_persona']),
        $conex->real_escape_string($post['ape_persona']),
        $conex->real_escape_string($post['clave_persona']),
        $conex->real_escape_string($post['correo_persona'])
    );

    $rs = mysqli_query($conex, $sentencia);

    if ($rs) {
        $respuesta = json_encode(array("estado" => true, "mensaje" => "Persona registrada correctamente"));
    } else {
        $respuesta = json_encode(array("estado" => false, "mensaje" => "Error al registrar la persona"));
    }

    echo $respuesta;
}

?>

