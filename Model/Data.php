<?php
Class Data {

  public static function loadJson($filepath, $arr_mode){
    $file = file_get_contents($filepath) or die("Unable to open file $filepath!");
    $json_data = json_decode($file, $arr_mode);

    return $json_data;
  }

}

?>
