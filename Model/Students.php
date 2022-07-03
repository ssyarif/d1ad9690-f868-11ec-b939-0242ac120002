<?php
Class Students {
  public $id;
  public $firstname;
  public $lastname;
  public $yearlevel;
  private $items;

  public function __construct(){
  }

  public function setData($json_data){
    $this->items = $json_data;
  }

  public function getAll(){

    return $this->items;
  }

  function getItemById($id){
    $found = false;
    foreach($this->items as $obj){
      if ($obj->id == $id){
        $found = true;
        break;
      }
    }

    if($found == false){
      echo "Unable to find the student with ID: $id in student record\n";
    }

    return $obj;
  }
}

?>
