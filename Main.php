<?php
require_once('.\Model\Data.php');
require_once('.\Model\Assessments.php');
require_once('.\Model\Questions.php');
require_once('.\Model\StudentResponses.php');
require_once('.\Model\Students.php');
require_once('.\Logic\Template.php');
require_once('.\Logic\Examiner.php');

#require_once('Markups.php');

Class Main {
  private static $studentid;
  private static $report_type;

  public static function run(){
    #Load JSon
    $students = new Students();
    $students->setData(Data::loadJson("Data/students.json", false));
    $studentsList = $students->getAll();

    $assessments = new Assessments();
    $assessments->setData(Data::loadJson("Data/Assessments.json", false));
    $assessmentsList = $assessments->getAll();

    $studentresponses = new StudentResponses();
    $studentresponses->setData(Data::loadJson("Data/student-responses.json", false));
    $studentresponsesList = $studentresponses->getAll();

    $questions = new Questions();
    $questions->setData(Data::loadJson("Data/Questions.json", false));
    $questionList = $questions->getAll();

    #start main console
    echo "Please enter the following\n";
    $inp_student = readline("Student ID: ");

    $student = $students->getItemById($inp_student);

    echo "Report to generate (1 for Diagnostic, 2 for Progress, 3 for Feedback):\n";
    $inp_report_type = readline("User Input: ");

    $result = $studentresponses->get_all_completed_assesment($studentresponsesList, $student);

    #assume only the last student responses is to be reviewed for feedback
    $last_responses = $studentresponses->getLastCompletionDate($result);

    ##assume to generate Diagnostic report from the latest completed assessment
    $assessment = $assessments->getItemById($assessmentsList, $last_responses->assessmentId);
    #var_dump($questionList);

    ##This Examiner object will evaluate last completed assessment and write rapport
    ##Assume list of the answer in questions.json is unique for the submitted assessment
    $examiner = new Examiner($assessment, $result, $questionList, $student);
    $student_results = $examiner->marking();

    ##Render the report
    Renderer::produceReport($student_results[$inp_report_type-1], $inp_report_type);
    #Template::Render($report_template);

  }

}

Main::run();







?>
