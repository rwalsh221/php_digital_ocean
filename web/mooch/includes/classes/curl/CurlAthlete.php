<?php 
require_once("CurlSettings.php");

class CurlAthlete extends CurlSettings {

   private $athleteInfo = array();

    private function setAthleteInfo() {
        $stravaApiCall = $this->curlInit();
        // var_dump($stravaApiCall);
        $stravaApiCallDecode = json_decode($stravaApiCall, true);
        $stravaApiCallDecodeKeys = array_keys($stravaApiCallDecode);

        foreach($stravaApiCallDecodeKeys as $key) {
            if($key === 'firstname' 
            || $key === 'lastname' 
            || $key === 'profile_medium') {
                $this->athleteInfo[$key] = $stravaApiCallDecode[$key];
            }
        };
        echo json_encode($this->athleteInfo, JSON_UNESCAPED_SLASHES);
    }

    public function getAthlete() {
        
        $this->setAthleteInfo();
    }
}
?>