<?php
Class Student {
  public $id;
  public $stem;
  public $type;
  public $strand;
  public $config;
  public $key;
  public $hint;

  function readJSon(string $filepath){
    $file = file_get_contents($filepath) or die("Unable to open file $filepath!");
    $jsonobj = json_decode($file);
    return $jsonobj;
  }
}

$st = new Student();
$data = $st->readJSon("Data/questions.json");

var_dump($data);

?>
