<?php
Class Students {
  public $id;
  public $firstname;
  public $lastname;
  public $yearlevel;

  function readJSon(string $filepath){
    $file = file_get_contents($filepath) or die("Unable to open file $filepath!");
    $jsonobj = json_decode($file);
    return $jsonobj;
  }

  function get_all($students){
    foreach($students as $obj){
      #echo $key["id"] . $key["firstName"];
      #echo $key->id;
      $student = (array) $obj;
      #echo $arr["id"] . $arr["firstName"] . $arr["lastName"] . $arr["yearLevel"];
      #echo "<br />";

      $details = array($student["firstName"],$student["lastName"],$student["yearLevel"]);
      $students = array($student["id"]=>$details);
      #var_dump($students);
      #echo "<br />";
    }

    #Please enter Student ID: ....
    #Please enter type of Report to generate: 1 Diagnostic/2 Progress/3 Feedback

    return $students;
  }

  function get_student($students, $id){
    $found = false;
    foreach($students as $obj){
      if ($obj->id == $id){
        #var_dump($obj);
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
