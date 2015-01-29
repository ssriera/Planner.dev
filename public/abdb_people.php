<?php
require_once('abdb_model.php');
Class People extends Model {
	
	public $fnameAdd = '';
	public $lnameAdd = '';
	public $phoneAdd = '';
	public $contactRemove = '';

	public function insert() {

		$query = "INSERT INTO people (first_name, last_name, phone) VALUES (:first_name, :last_name, :phone)";

		$stmt = $this->dbc->prepare($query);

    	$stmt->bindValue(':first_name', $this->fnameAdd, PDO::PARAM_STR);
    	$stmt->bindValue(':last_name', $this->lnameAdd, PDO::PARAM_STR);
    	$stmt->bindValue(':phone', $this->phoneAdd, PDO::PARAM_STR);
    
    	 $stmt->execute();
	}

	public function delete() {

	  $query = "DELETE FROM people where id = :id"; 
	  
	  $stmt = $this->dbc->prepare($query);
	  $stmt->bindValue(':id', $this->contactRemove, PDO::PARAM_INT);

	  $stmt->execute();

	}

//Delete the addresses associated with the FK person_id
	public function deleteFK() {

	  $query = "DELETE FROM address where person_id = :person_id";
	  
	  $stmt = $this->dbc->prepare($query);
	  $stmt->bindValue(':person_id', $this->contactRemove, PDO::PARAM_INT);

	  $stmt->execute();

	}
	
}