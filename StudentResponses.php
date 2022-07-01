<?php
Class StudentResponses{
  private $id;
  private $file_path;
  private $assessmentId;
  private $assigned;
  private $started;
  private $completed;
  private $student;
  private $responses;
  private $results;
  private $items;
  private $completed_assessment = array();

  public function __construct($filepath){
    $this->filepath = $filepath;
    $file = file_get_contents($this->filepath) or die("Unable to open file $this->filepath!");
    $this->items = json_decode($file);
  }

  function get_all(){
    return $this->items;
  }

  function get_all_student_assesment($student_id){

    foreach ($this->items as $assessment){
      if (property_exists($assessment,"completed") and $assessment->student->id == $student_id){
        $yearLevel = $assessment->student->yearLevel;
        $responses = $assessment->responses[0]->questionId;
        #echo "$assessment->id $assessment->assessmentId $assessment->completed $yearLevel $responses has been completed\n";
        array_push($this->completed_assessment, $assessment);

      }
      elseif ($assessment->student->id == $student_id && !property_exists($assessment,"completed")){
        /*do something for some in progress assessment*/

      }
    }

    if($this->completed_assessment == NULL){

    }

    return $this->completed_assessment;
  }


  ###Check again if swapping element is working
  function sortByCompletionDate($assessments){
    var_dump($assessments);
    function date_compare($item1, $item2){
      #var_dump($item1);
      $datetime1 = strtotime($item1->completed);
      $datetime2 = strtotime($item2->completed);
      return $datetime1 - $datetime2;
    }

    if(is_array($assessments)){
      $sorted = usort($assessments, 'date_compare');
      print_r($sorted);
      #var_dump($sorted);
    }
    else{
      echo "There is no completed assessment";
    }
  }

  function getLastCompletionDate($assessments){
    if(is_array($assessments)){
      return end($assessments);
    }
    else{
      #echo "Passing argument must be an array";
    }
  }

}

?>
