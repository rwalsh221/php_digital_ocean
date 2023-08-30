<?php 
require_once("CurlSettings.php");

class CurlAthlete extends CurlSettings {

   private $athleteInfo = array();

    private function setAthleteInfo() {
        $stravaApiCall = $this->curlInit();
        // var_dump($stravaApiCall);
        $stravaApiCallDecode = json_decode($stravaApiCall, true);
        $stravaApiCallDecodeKeys = array_keys($stravaApiCallDecode);
        // var_dump($stravaApiCallDecode);
        foreach($stravaApiCallDecodeKeys as $key) {
            if($key === 'firstname' 
            || $key === 'lastname' 
            || $key === 'profile_medium'
            || $key === 'id') {
                $this->athleteInfo[$key] = $stravaApiCallDecode[$key];
            }
        };
        return $this->athleteInfo;
    }

    public function getAthlete() {
        
        return $this->setAthleteInfo();
    }

   
}
?>