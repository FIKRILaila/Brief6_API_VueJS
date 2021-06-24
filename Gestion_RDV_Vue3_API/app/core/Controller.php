<?php
require_once '../app/vendor/autoload.php';
use \Firebase\JWT\JWT;

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');


class Controller{
 
  public $data=[];
  public $key ="laila";


  public function index(){
  }
  public function model($model){
    require_once '../app/models/'.$model.'.php';
    return new $model();
  }

  public function authorization($ref){
    $iat = time();
    $exp = $iat + 60 * 60;
    $payload = array(
        "iss" => "localhost",
        "aud" => "localhost",
        "iat" => $iat,
        'exp' => $exp,
        'ref' => $ref,
    );
    $jwt = JWT::encode($payload, $this->key,'HS512');
    return $jwt;
  }

  public function gettoken(){
        $headers = apache_request_headers();
        if (isset($headers['Authorization'])) {
          return str_replace('Bearer ','',$headers['Authorization']);
        }else{
            return false;
        }
   }
     public function verification($token){
           return JWT::decode($token, $this->key,array('HS512'));
     }
   
}



?>
