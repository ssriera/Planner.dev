<?php
require_once('abdb_model.php');
Class People extends Model {
	
	public $fnameAdd = '';
	public $lnameAdd = '';
	public $phoneAdd = '';

	public function insert() {

		$query = "INSERT INTO people (first_name, last_name, phone) VALUES (:first_name, :last_name, :phone)";

		$stmt = $this->dbc->prepare($query);

    	$stmt->bindValue(':first_name', $this->fnameAdd, PDO::PARAM_STR);
    	$stmt->bindValue(':last_name', $this->lnameAdd, PDO::PARAM_STR);
    	$stmt->bindValue(':phone', $this->phoneAdd, PDO::PARAM_STR);
    
    	 $stmt->execute();
	}
	
}