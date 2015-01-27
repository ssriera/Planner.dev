<?php
class Model {
  protected $dbc;
  public $id;
  public function __construct($dbc) {
    $this->dbc = $dbc;
  }
  
  public function save() {
    if (isset($this->id)) {
      return $this->update();
    } else {
      return $this->$insert();
    }
  }
}
