<?php
class ReservationModel {

    private $con;

    public function __construct(){
        $this->con=new Database();
    }

    public function getByRef($ref){
        try{
            $reservations= $this->con->con->prepare('SELECT * FROM Reservation WHERE ref = :ref');
            $reservations->execute(array(":ref"=>$ref));
            return $reservations->fetchAll();
        }catch(PDOException $ex){
            echo 'erreur' .$ex->getMessage();
        }
    }
    public function getById($id_r){
        try{
            $reservations= $this->con->con->prepare('SELECT * FROM Reservation WHERE id_r = :id_r');
            $reservations->execute(array(":id_r"=>$id_r));
            return $reservations->fetch(PDO::FETCH_OBJ);
        }catch(PDOException $ex){
            echo 'erreur' .$ex->getMessage();
        }
    }

    public function getbyDate($date){
        try{
            $reservations= $this->con->con->prepare('SELECT * FROM Reservation WHERE date = :date');
            $reservations->execute(array(":date"=>$date));
            return $reservations->fetchAll();
        }catch(PDOException $ex){
            echo 'erreur' .$ex->getMessage();
        }

    }
    public function edit($date,$periode,$ref,$id_r){
        try{
            $reservation= $this->con->con->prepare('UPDATE Reservation SET date = :date ,periode= :periode ,ref = :ref WHERE id_r = :id_r');
            $edit = $reservation->execute(array(":date"=>$date,"periode"=>$periode,":ref"=>$ref, ":id_r"=>$id_r));
            if($edit){
                return true;
            }else{
                return false;
            }
        }catch(PDOException $ex){
            echo 'erreur' .$ex->getMessage();
        }
    }

    public function add($date,$periode,$ref){
        try{
            $reservation= $this->con->con->prepare('INSERT INTO Reservation (date,periode,ref) VALUE (:date,:periode,:ref)');
            $add = $reservation->execute(array(":date"=>$date,"periode"=>$periode,":ref"=>$ref));
            if($add){
                return true;
            }else{
                return false;
            }  
        }catch(PDOException $ex){
            echo 'erreur' .$ex->getMessage();
        }
       
    }

    public function delete($id_r){
        try{
            $reservation= $this->con->con->prepare('DELETE FROM Reservation WHERE id_r = :id_r');
            $delete = $reservation->execute(array(":id_r"=>$id_r));
            if($delete){
                return true;
            }else{
                return false;
            }  
        }catch(PDOException $ex){
            echo 'erreur' .$ex->getMessage();
        }
       
    }

}
?>