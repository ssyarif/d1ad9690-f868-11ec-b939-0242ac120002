<?php
Class Assessments {
  private $id;
  private $name;
  private $questions;
  private $filepath;
  private $items;

  public function __construct(){
  }

  public function setData($json_data){
    $this->items = $json_data;
  }

  public function getAll(){
    return $this->items;
  }

  public function getItemById($assessments, $id){
    $assessment = NULL;
    $counter = 0;

    foreach($assessments as $item){

        if($id == $item->id){
          $assessment = $item;

        }
        $counter++;
    }

    if ($assessments == NULL){
      echo "There is no assessment to be in the data. \n";
    }

    return $assessment;
  }

}

?>
