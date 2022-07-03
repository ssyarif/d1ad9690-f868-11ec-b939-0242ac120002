<?php
Class Renderer {
  private static $report_type;

  public static function getTemplate($input_no){
    switch ($input_no){
      case "1":
        $report = "Diagnostic";
        break;
      case "2":
        $report = "Progress";
        break;
      case "3":
        $report = "Feedback";
        break;
    }
    $file_path = "Template/" . $report . ".txt";
    $text = file_get_contents($file_path) or die("Unable to open file $file_path!");

    return $text;
  }

  ###for future project, automate variable fields into report templated text file
  ###Currently does not work as expected
  ###Render manually
  public static function produceReport($result, $input_type){
    $fields = array();
    $value = array();

    $fullname = $result["fullname"];
    $assessment_name = $result["assessment_name"];


    foreach($result as $key => $value){
      $pattern = "[[" . strtoupper($key) . "]]";
      ###preformat

      if( preg_match("/list/", $key) ){
          $list = join("\n", $value);
      }

    }

    #str_replace($pattern, $text, $value);

    ##For Diagnostic Report
    if ($input_type == 1){
      $completed_assessment = $result["completed_assessment"];
      $total  = $result["total"];
      $tot_strand = $result["tot_strand"];

      $text = "$fullname recently completed $assessment_name assessment $completed_assessment\n" .
               "He got $total questions right out of $tot_strand. Details by strand given below\n\n" .
               $list;

      echo $text;
    }
    elseif ($input_type == 2){
      $tot_assessment = $result["tot_assessment"];
      $eval_result = $result["eval_result"];

      $text = "$fullname has completed $assessment_name assessment $tot_assessment times in total. Date and raw score given below:\n\n" .
               $list .
               "\n\n$fullname $eval_result";


      echo $text;
    }

    elseif ($input_type == 3){
      $completed_assessment = $result["completed_assessment"];
      $total  = $result["total"];
      $tot_strand = $result["tot_strand"];

      $text = "$fullname recently completed $assessment_name assessment on $completed_assessment" .
              "He got $total questions right out of $tot_strand. Feedback for wrong answers given below\n\n" . $list;

      echo $text;
    }


  }


}

?>
