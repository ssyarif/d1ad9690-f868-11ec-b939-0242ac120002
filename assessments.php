<?php
Class Assessments {
  public $id;
  public $name;
  public $questions;

  function readJSon(string $filepath){
    $file = file_get_contents($filepath) or die("Unable to open file $filepath!");
    $jsonobj = json_decode($file);
    return $jsonobj;
  }
}

$as = new Assessments();
$data = $as->readJSon("Data/assessments.json");

var_dump($data);

?>
