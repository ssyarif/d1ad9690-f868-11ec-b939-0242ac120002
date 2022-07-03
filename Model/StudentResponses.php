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

  function get_all_completed_assesment($studentResponses, $student){
    $student_name = "$student->firstName $student->lastName";
    $assessmentList = array();

    if ($studentResponses == NULL){
      print "There is no Completed Student Assessments to be sorted\n";

      return;
    }

    #var_dump($assessmentList);
    #Only pull completed assessment
    foreach ($studentResponses as $item){
      #var_dump($item->id);
      if($item->student->id != $student->id && !property_exists($item,"completed")){
        echo "$student_name has not completed any assessment in student responses\n";
        echo "There is nothing to report, terminating the program\n";
        exit();
      }
      elseif ($item->student->id == $student->id && !property_exists($item,"completed")){
        ###do something for some in progress assessment
        $yearLevel = (string) $item->student->yearLevel;
        #$assigned_date = (string)
        echo "$student_name has not finished assessment Year $yearLevel assigned on $item->assigned \n\n";
      }
      elseif ($item->completed and $item->student->id == $student->id){
        $yearLevel = $item->student->yearLevel;
        $responses = $item->responses[0]->questionId;
        #echo "$assessment->id $assessment->assessmentId $assessment->completed $yearLevel $responses has been completed\n";
        array_push($assessmentList, $item);

      }

    }

    return $assessmentList;
  }


  ###Check again if sorting array is working
  function sortByCompletionDate($studentResponses){

    function date_compare($item1, $item2){
      #var_dump($item1);
      $datetime1 = strtotime($item1->completed);
      $datetime2 = strtotime($item2->completed);
      #echo "$datetime2 --";
      return $datetime1 - $datetime2;
    }

    if (is_array($studentResponses)){
      $sorted = usort($studentResponses, 'date_compare');
      #print_r($sorted);
      #var_dump($sorted);
    }
    else{
      print "There is no Student Assessments to be sorted.\n";
    }

    return $sorted;
  }

  function getLastCompletionDate($studentResponses){
    if(is_array($studentResponses)){
      foreach($studentResponses as $item){

      }

      return end($studentResponses);
    }
    else{
      #echo "Passing argument must be an array";
    }
  }

}

?>
