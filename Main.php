<?php
require_once('Assessments.php');
require_once('Questions.php');
require_once('StudentResponses.php');
require_once('Students.php');
require_once('Template.php');
#require_once('Markups.php');

Class Main {
  private static $studentid;
  private static $report_type;

  public static function run($args){

  }

}

$st = new Students();
$student_data = $st->readJSon("Data/students.json",true);

$as = new Assessments();
$assessment_data = $as->readJSon("Data/Assessments.json",true);

$sr = new StudentResponses("Data/student-responses.json");
#$sr_data = $as->readJSon("Data/student-responses.json",true);


$student = "student1";

$report_template = Template::get_Template("Diagnostic");
$st_details = $st->get_student($student_data,$student);

$pattern = "/\[students-firstName\]/i";

$report_text = preg_replace($pattern, $st_details->firstName . " " . $st_details->lastName, $report_template );

#var_dump($sr->get_all_student_assesment($student));
$result = $sr->get_all_student_assesment($student);
#$result = $sr->sortByCompletionDate($result);

$sr->sortByCompletionDate($result);

#echo $report_text;

#var_dump($students_data);

?>
