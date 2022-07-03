<?php

Class Examiner{
  private $submission;
  private $answers;
  private $assessment;
  private $student;

  public function __construct($assessment, $submission, $answers, $student){
    $this->assessment = $assessment;
    $this->submission = $submission;
    $this->answers = $answers;
    $this->student = $student;
  }

  public function marking(){
    $assessment = $this->assessment;
    $progressList = $this->submission;
    #get the matching submission against studentid, assesmentid
    foreach($this->submission as $item){
      if ($item->assessmentId = $assessment->id){
        $submission = $item;
        break;
      }
    }

    $response_id = $submission->id;
    $assessment_id = $this->assessment->id;
    $assessment_name = $this->assessment->name;
    $completed = $submission->completed;

    #$questionList = $questions;
    #var_dump($this->submission);
    $answerList = (array) $this->answers;
    $submissionList = (array) $submission->responses;

    if (count($answerList) != count($submissionList)){
      echo "Warning\n";
      echo "The total answers in $assessment_name answer list with Assessment ID: $assessment_id is not the same\n";
      echo "with the total of of student answers with student response id $response_id on $completed\n";
      echo "Return error if needed\n\n\n";
    }

    #var_dump($submissionList);

    #Marking the answer
    $strands = array();
    $unique_strands = array();
    $correct_strands = array();
    $correct_answers = array();
    $total_corrects = 0;
    $total_incorrects = 0;
    $total_questions = 1;
    $feedbacks = array();
    $total_strand = count($answerList);

    #assume the number of student answer and prepared answer is the same as 16 items
    #and in the the same order. The actual total items from questions.json is 17 as
    #questionid "numeracy10" is duplicated
    for ($i = 0; $i <= 15; $i++) {
      $answer = $answerList[$i];
      $attempt = $submissionList[$i];
      $options = $answer->config->options;

      #var_dump($options);
      #var_dump($attempt);

      ##Check if the questions->id matched with student-responses->responses->questionId
      #if ($answer->id == $attempt->questionId){      #uncomment if the id always match

        $key = $answer->config->key;

        ##Student answers correctly
        if ($answer->config->key == $attempt->response){
          array_push($correct_strands, $answer->strand);
          #var_dump($answer->config->key);
          $total_corrects++;
        }
        ##For wrong answer, prepare the feedback
        else{
          foreach($options as $option){
            if ($option->id == $attempt->response){
              $wrong_answer = "Your Answer: $option->label with value $option->value";
            }
            elseif ($option->id == $answer->config->key){
              $right_answer = "Right Answer: $option->label with value $option->value";
            }
          }
          $question = "Question: $answer->stem";
          $hint = $answer->config->hint;
          $hint = "Hint: $hint";

          array_push($feedbacks, $question);
          array_push($feedbacks, $wrong_answer);
          array_push($feedbacks, $right_answer);
          array_push($feedbacks, $hint);
          array_push($feedbacks, "\n");
          #var_dump($feedbacks);
          $total_incorrects++;
        }
        $total_questions++;
      }

      #$item = (object) $item;
      #var_dump($item);
      #var_dump($last_assessment->responses[1]);
    #}  #uncomment this bracket if validating answer by its id is required

    #get strand details and its number of occurence for reporting
    foreach($answerList as $item){
      array_push($strands, $item->strand);
    }
    $unique_strands = array_count_values($strands);
    $unique_correct_strands = array_count_values($correct_strands);
    #print_r($unique_correct_strands["Number and Algebra"]);

    #check if both array strands has the same number of keys
    #Prepare the format
    $strandList = array();
    foreach($unique_strands as $key => $value){
      if (!array_key_exists($key, $unique_correct_strands)){
        echo "Found $key is not in the unique_correct_strands, put value as 0\n\n";
        $unique_correct_strands[$key] = 0;
      }
      array_push($strandList, "$key: $unique_correct_strands[$key] out of $value correct\n");
    }


    #date formatting doesn't work
    $date_fmt = 'd/m/Y H:M:S';
    $date_result = 'jS F Y H:i A';
    #$dt = (new DateTime($submission->completed))->format($date_result);
    #$date = dt->format($date_result);
    #var_dump($dt);

    #var_dump($strandList);
    #for diagnostic report;
    $student_name = $this->student->firstName . " " . $this->student->lastName;
    $diagnostic_report = array();
    $diagnostic_report["fullname"] = $student_name;
    $diagnostic_report["assessment_name"] = $assessment_name;
    $diagnostic_report["completed_assessment"] = $submission->completed;
    $diagnostic_report["total"] = $total_corrects;
    $diagnostic_report["tot_strand"] = $total_strand;
    $diagnostic_report["list"] = $strandList;
    #var_dump($diagnostic_report);

    $progressItems = array();
    #for progress report
    $tot_assessment = count($progressList);
    foreach($progressList as $item){
      #var_dump($item);
      $raw_score = $item->results->rawScore;
      $tot_question = count($item->responses);
      $progress = "Date: " . $submission->completed . ", Raw Score: " . $raw_score . " out of " . $tot_question;
      array_push($progressItems, $progress);
    }

    #for student progress,
    if($tot_assessment > 1){
      $first_test = $progressList[0]->results->rawScore;
      $current_test = $progressList[$tot_assessment-1]->results->rawScore;

      if($first_test < $current_test){
        $review_text = (string) "got " . ($current_test - $first_test) . " more correct ";
      }
      else{
        $review_text = (string) "got " . ($current_test - $first_test) . " less correct ";
      }
      $review_text .= "in the recent completed assessment than the oldest";
    }
    else{
      $review_text = "$student_name has only taken $tot_assessment assessment so far.\n";
    }

    #var_dump($raw_score);
    #var_dump($progressList);

    $progress_report = array();
    $progress_report["fullname"] = $student_name;
    $progress_report["assessment_name"] = $assessment_name;
    $progress_report["tot_assessment"] = $tot_assessment;
    $progress_report["list"] = $progressItems;
    $progress_report["eval_result"] = $review_text;
    #var_dump($progress_report);

    #for feedback report
    $feedback_report = array();
    $feedback_report["fullname"] = $student_name;
    $feedback_report["assessment_name"] = $assessment_name;
    $feedback_report["completed_assessment"] = $submission->completed;
    $feedback_report["total"] = $total_corrects;
    $feedback_report["tot_strand"] = $total_strand;
    $feedback_report["list"] = $feedbacks;
    #ar_dump($feedback_report);

    return array($diagnostic_report, $progress_report, $feedback_report);
  }

  public function setAssessment($submission){
    $this->assessment = $assessment;
  }

  private function getAssessment(){
    return $this->assessment;
  }

  public function setSubmission($submission){
    $this->submission = $submission;
  }

  private function getSubmission(){
    return $this->submission;
  }

  public function setAnswers($answers){
    $this->answers = $answers;
  }

  private function getAnswers(){
    return $this->answers;
  }

  public function evalMonth(){

  }

}

?>
