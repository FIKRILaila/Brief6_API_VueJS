<?php
class PatientModel{
    private $con;
    public function __construct(){
        $this->con=new Database();
    }
    function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
    public function register($nom,$prenom,$dateNaiss,$password,$email){
        $options = [
            'cost' => 12,
        ];
        $ref = $this->generateRandomString(10);
        $register = $this->con->con->prepare("INSERT INTO `patient` (`ref`,`nom`, `prenom`, `dateNaiss`, `password` ,`email`) VALUES (:ref, :nom, :prenom, :dateNaiss, :password, :email)");
        $result = $register->execute(array(":ref" =>$ref,
                                            ":nom" =>$nom, 
                                            "prenom" => $prenom, 
                                            ":dateNaiss"=>$dateNaiss,
                                            ":email"=>$email,
                                            ":password" => PASSWORD_HASH($password, PASSWORD_BCRYPT, $options)));
        if($result){
            return $this->getUserbyRef($ref);
        }else{
            return false;
        } 
    }
    public function getUserbyRef($ref){
        $login = $this->con->con->prepare("SELECT * FROM patient WHERE ref = :ref ");
        $login->execute(array(":ref"=>$ref));
        $row = $login->fetch(PDO::FETCH_OBJ);
        return $row;
    }
    
    public function login($data){
       
        $login = $this->con->con->prepare("SELECT * FROM patient WHERE email = :email ");
        $login->execute(array(":email"=>$data->email));
        // echo 'yep clear';
        $row = $login->fetch(PDO::FETCH_OBJ);
        if($row){
            if (password_verify($data->password,$row->password)){
                $res = array(
                    "status"=> true,
                    "User" => $row
                );
                return  $res;
            }else{
                $res =array(
                    "status" => false
                );
                return $res;
            }
        }else{
            $res =array(
                "status" => false
            );
            return $res;
        }
    }
}

?>