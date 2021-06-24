<?php
class Database{
        private $server='localhost';
        private $user='root';
        private $pass='';
        private $dbname='gestionrdv';

        public $con;

        public function __construct(){
            $db= 'mysql:host='.$this->server.';dbname='.$this->dbname;
            $options=array(
                PDO::ATTR_PERSISTENT=>true,
                PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION, 
            );
            try {
            $this->con=new PDO($db,$this->user,$this->pass,$options);
            } catch(PDOException $ex){
                echo 'erreur' .$ex->getMessage();
            }
        }
        
}
?>