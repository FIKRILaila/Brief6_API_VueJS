<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');


class Patient extends Controller{
    public $data;
    public function __construct(){
     $this->PatientModel=$this->model('PatientModel');
    }
    public function register(){
        try{
            $user=$this->PatientModel->register($this->data->nom,$this->data->prenom,$this->data->dateNaiss,$this->data->password,$this->data->email);
            $token = $this->authorization($user->ref);
            print_r(json_encode(array(
                'User' => $user,
                'Token' => $token,
            )));
        } catch (\PDOExeption $err){
            http_response_code(500);
            print_r(json_encode(array('error' => $err->getMessage())));
            die();
        }

    }
    // public function register(){
    //     $register=$this->PatientModel->register($this->data->nom,$this->data->prenom,$this->data->dateNaiss,$this->data->password,$this->data->email);
    //     print_r(json_encode($register));
    // }

    public function login(){
        $checkuser=$this->PatientModel->login($this->data);
        if($checkuser['status']==true){
            $token=$this->authorization($checkuser['User']->ref);
            print_r(json_encode(array(
                'checkuser' => $checkuser['status'],
                'Token' => $token,
                'User'=>$checkuser['User']
            )));
        }else{
            print_r(json_encode($checkuser['status']));
        }
    }
}
?>