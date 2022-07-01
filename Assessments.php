<?php
Class Assessments {
  private $id;
  private $name;
  private $questions;

  function readJSon(string $filepath){
    $file = file_get_contents($filepath) or die("Unable to open file $filepath!");
    $jsonobj = json_decode($file);
    return $jsonobj;
  }

  function get_all($assessments){
    foreach($assessments as $obj){
      $qst = (object)$obj->questions[0];
      var_dump($qst->questionId);
    }
    return $assessments;
  }
}

?>
