<?php
Class Student {
  public $id;
  public $firstname;
  public $lastname;
  public $yearlevel;

  function readJSon(string $filepath){
    $file = file_get_contents($filepath) or die("Unable to open file $filepath!");
    $jsonobj = json_decode($file);
    return $jsonobj;
  }
}

$st = new Student();
$data = $st->readJSon("Data/students.json");

var_dump($data);

?>
