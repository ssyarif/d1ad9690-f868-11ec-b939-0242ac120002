<?php
Class Questions {
  private $items;

  #public function __construct($filepath){
  #  $file = file_get_contents($filepath) or die("Unable to open file $filepath!");
  #  $this->items = json_decode($file);
  #}

  public function __construct(){
  }

  public function setData($json_data){
    $this->items = $json_data;
  }

  public function getAll(){
    return $this->items;
  }

  public function getItemById($id){
    $question = NULL;
    $items = $this->items;
    $counter = 0;

    foreach($items as $item){

        if($id == $item->id){
          #var_dump($item->stem);
          $question = $item;

        }
        $counter++;
    }

    return $question;
  }

}

?>
