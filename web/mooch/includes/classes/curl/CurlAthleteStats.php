<?php 
require_once("CurlSettings.php");

class CurlAthleteStats extends CurlSettings {
    private $athleteStats = array();
    
    private function setAthleteStats($activityType, $athleteStatsArray) {
        $this->athleteStats[$activityType] = $athleteStatsArray[$activityType]['distance'];
    }

    private function curlAthleteStats() {
        $stravaApiCallJson = $this->curlInit();
        
        $stravaApiCallDecode = json_decode($stravaApiCallJson, true);
        $stravaApiCallDecodeKeys = array_keys($stravaApiCallDecode);

        foreach($stravaApiCallDecodeKeys as $key) {
            if (gettype($stravaApiCallDecode[$key]) === 'array' && !str_starts_with($key, 'recent')) {
                $this->setAthleteStats($key, $stravaApiCallDecode);
            };
        }
    }

    public function getAthleteStats() {
        $this->curlAthleteStats();
        // echo json_encode($this->athleteStats);
        return $this->athleteStats;
   }
}
?>