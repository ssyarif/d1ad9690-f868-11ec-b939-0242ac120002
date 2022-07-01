<?php
Class Template {
  private static $report_type;

  public static function get_Template($report_type){
    $file_path = "Template/" .$report_type . ".txt";
    $text = file_get_contents($file_path) or die("Unable to open file $file_path!");

    return $text;
  }
}

?>
