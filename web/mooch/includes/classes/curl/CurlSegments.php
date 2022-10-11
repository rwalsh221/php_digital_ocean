<?php 
require_once("CurlSettings.php");

class CurlSegments extends CurlSettings {

  public function getSegment() {

    $result = $this->curlInit();

    return $result;

  }

  
}
?>