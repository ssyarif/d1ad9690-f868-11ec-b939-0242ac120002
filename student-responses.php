<?php
Class StudentResponses {
  public $id;
  public $assessmentId;
  public $assigned;
  public $started;
  public $completed;
  public $student;
  public $responses;
  public $results;

  function readJSon(string $filepath){
    $file = file_get_contents($filepath) or die("Unable to open file $filepath!");
    $jsonobj = json_decode($file);
    return $jsonobj;
  }
}

$st = new StudentResponses();
$data = $st->readJSon("Data/students-responses.json");

var_dump($data);

?>
