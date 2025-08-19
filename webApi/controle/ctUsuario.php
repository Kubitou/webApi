<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-Width");

require_once '../config/database.php';
require_once '../models/usuarios.php';

$database = new Database();
$db = $database->getConnection();

$usuario = new Usuario($db);
$method = $_SERVER['REQUEST_METHOD'];

switch($method){
    case 'GET':
        if(isset($_GET["id"])){
            $usuario->id = $_GET["id"];
            $usuario->readOne();
            if($usuario->name != null){
                $usuario_arr=array(
                    "id"=>$usuario->id,
                    "nome"=>$usuario->name,
                    "email"=>$usuario->email,
                    "ra"=>$usuario->ra,
                    "celular"=>$usuario->celular
                );
                http_response_code(200);
                echo json_encode($usuario_arr);
            }else{
                http_response_code(404);
                echo json_encode(array("message"=>"Usuario não Cadastrado."));
            }
        }else{
            $stmt = $usuario->read();
            $usuario = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if(!empty($usuario)){
                http_response_code(200);
                echo json_encode(["records"=>$usuario]);
            }else{
                http_response_code(404);
                echo json_encode(array("messge"=>"Usuario não Cadastrado."));
            }
        }
    break;
    case 'DELETE':
        $data = json_decode(file_get_contents("php://input"));
        $usuario->id = $data->id;
        if($usuario->delete()){
            http_response_code(200);
            echo json_encode(array("message"=>"Usuario excluido com sucesso."));
        }else{
            http_response_code(404);
            echo json_encode(array("message"=>"Falha na exclusão de dados."));
        }
    break;
    case 'PUT':{
        $data = json_decode(file_get_contents("php://input"));
        $usuario->id = $data->id;
        $usuario->name = $data->nome;
        $usuario->email  = $data->email;
        $usuario->ra  = $data->ra;
        $usuario->celular = $data->celular;
        if($usuario->update()){
            http_response_code(200);
            echo json_encode(array("message"=> "usuario atualizado com sucesso"));
        }else{
            http_response_code(503);
            echo json_encode(array("message"=> "falha na atualização de dados"));
        }
    }
    break;
    case 'POST':{
        $data = json_decode(file_get_contents("php://input"));
        echo json_encode($data);
        $usuario->name = $data->nome;
        $usuario->email  = $data->email;
        $usuario->ra  = $data->ra;
        $usuario->senha = $data->senha;
        $usuario->celular = $data->celular;
        if($usuario->create()){
            http_response_code(200);
            echo json_encode(array("message"=> "usuario cadastrado com sucesso"));
        }else{
            http_response_code(503);
            echo json_encode(array("message"=> "falha na inclusão de dados"));
        }
    }
    break;
}
?>
