<?php
require_once('abdb_model.php');
Class Address extends Model {
	
	public $streetAdd = '';
	public $aptAdd = '';
	public $cityAdd = '';
	public $stateAdd = '';
	public $zipAdd = '';
	public $personAdd = '';
	public $addressRemove = '';


	public function insert() {
		$query = "INSERT INTO address (street, apt, city, state, zip, person_id) VALUES (:street, :apt, :city, :state, :zip, :person_id)";
		
		$stmt = $this->dbc->prepare($query);

    	$stmt->bindValue(':street', $this->streetAdd, PDO::PARAM_STR);
    	$stmt->bindValue(':apt', $this->aptAdd, PDO::PARAM_STR);
    	$stmt->bindValue(':city', $this->cityAdd, PDO::PARAM_STR);
    	$stmt->bindValue(':state', $this->stateAdd, PDO::PARAM_STR);
    	$stmt->bindValue(':zip', $this->zipAdd, PDO::PARAM_STR);
    	$stmt->bindValue(':person_id', $this->personAdd, PDO::PARAM_INT);

    	$stmt->execute();
	}


	public function delete() {

	  $query = "DELETE FROM address where id = :id"; 
	  
	  $stmt = $this->dbc->prepare($query);
	  $stmt->bindValue(':id', $this->addressRemove, PDO::PARAM_INT);

	  $stmt->execute();

	  	// var_dump($this->addressRemove);


	}

}
