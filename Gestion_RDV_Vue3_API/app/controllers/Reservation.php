<?php 

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');


require_once 'vendor/autoload.php';

class Reservation extends Controller{

    public $data=[];

    public function __construct(){
     $this->ReservationModel=$this->model('ReservationModel');
    }

    public function getReservationByDate(){
        if($this->gettoken()!=null){
            try{
                $this->verification($this->gettoken());
                $Reservations = $this->ReservationModel->getbyDate($this->data->date);
                print_r(json_encode($Reservations));
            }catch (\Throwable $th) {
                print_r(json_encode("unauthorizedtoken"));
            }
        }else{
         print_r(json_encode("unauthorizedheader"));
        }
    }
        
    public function getReservationByRef()
    {
        if($this->gettoken()!=null){
            try{
                $result = $this->verification($this->gettoken());
                $Reservations = $this->ReservationModel->getByRef($result->ref);
                print_r(json_encode($Reservations));
            }catch (\Throwable $th){
                print_r(json_encode("unauthorizedtoken"));
            }
       }else{
        print_r(json_encode("unauthorizedheader"));
       }
       
    }   
    public function getReservationById()
    {
        if($this->gettoken()!=null){
            try{
                $result = $this->verification($this->gettoken());
                $Reservations = $this->ReservationModel->getById($this->data->id_r);
                print_r(json_encode($Reservations));
            }catch (\Throwable $th){
                print_r(json_encode("unauthorizedtoken"));
            }
       }else{
        print_r(json_encode("unauthorizedheader"));
       }
       
    }  
    public function newReservation()
    {
        if($this->gettoken()!=null){
            try{ 
                $result= $this->verification($this->gettoken());
                $Reservation = $this->ReservationModel->add($this->data->date,$this->data->periode,$result->ref);
                print_r(json_encode($Reservation));
            }catch (\Throwable $th){
                print_r(json_encode("unauthorizedtoken"));
            }
       }else{
            print_r(json_encode("unauthorizedheader"));
       }    
    }

    public function deleteReservation()
    {
        if($this->gettoken()!=null){
            try{
                print_r($this->data);
                $this->verification($this->gettoken());
                $result = $this->ReservationModel->delete($this->data->id_r);
                print_r(json_encode($result));
            }catch (\Throwable $th){
                print_r(json_encode("unauthorizedtoken"));
            }
       }else{
            print_r(json_encode("unauthorizedheader"));
       }  
       
    }

    public function editReservation()
    {
        if($this->gettoken()!=null){
            try{
                $result = $this->verification($this->gettoken());
                $result = $this->ReservationModel->edit($this->data->date,$this->data->periode,$result->ref,$this->data->id_r);
                print_r(json_encode($result));
            }catch (\Throwable $th){
                print_r(json_encode("unauthorizedtoken"));
            }
       }else{
            print_r(json_encode("unauthorizedheader"));
       }  
      
    }


}
