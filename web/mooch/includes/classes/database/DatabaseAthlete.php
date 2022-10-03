<?php 
require_once('DatabaseSettings.php');

class DatabaseAthlete extends DatabaseSettings {

    public function getAthlete($userId) {
        $sql = "SELECT firstName, lastName, profileImgUrl
         FROM athlete WHERE userId='$userId'";
        $dbResult = $this->getFromDatabase($sql);
        return $dbResult;
}

    public function registerAthlete($userId, $userEmail, $stravaAthleteId, $firstName, $lastName, $profileImgUrl, 
    $tokenExpiresAt, $tokenExpiresIn, $stravaClientId, $stravaClientSecret, $accessToken, $refreshToken) {
        $sql = "INSERT INTO athlete (userId, userEmail, stravaAthleteId, firstName, lastName, unitPreference, profileImgUrl, tokenExpiresAt, tokenExpiresIn, stravaClientId, stravaClientSecret, accessToken, refreshToken)
        VALUES ('$userId', '$userEmail' ,'$stravaAthleteId', '$firstName', '$lastName', 'kilometre', '$profileImgUrl', '$tokenExpiresAt', '$tokenExpiresIn', '$stravaClientId', '$stravaClientSecret', '$accessToken', '$refreshToken')";

    $this->insertIntoDatabase($sql);
    }

    public function getAthleteStats($userId) {
        $sql = "SELECT rideAllTimeDist, rideYearDist, runAllTimeDist, runYearDist, swimAllTimeDist, swimYearDist
         FROM athleteStats WHERE userId='$userId'";
        $dbResult = $this->getFromDatabase($sql);
        return $dbResult;
    }

    public function initAthletestats($userId, $athleteStats) {
        ['all_ride_totals'=>$all_ride_totals, 'ytd_ride_totals'=>$ytd_ride_totals,
        'all_run_totals'=>$all_run_totals, 'ytd_run_totals'=>$ytd_run_totals,
        'all_swim_totals'=>$all_swim_totals, 'ytd_swim_totals'=>$ytd_swim_totals] = $athleteStats;
        $sql = "INSERT INTO athleteStats (userId, rideAllTimeDist, rideYearDist, runAllTimeDist, runYearDist, swimAllTimeDist, swimYearDist)
            VALUES ($userId, $all_ride_totals, $ytd_ride_totals, $all_run_totals, $ytd_run_totals, $all_swim_totals, $ytd_swim_totals)";
    }

    public function insertAthleteStats($userId, $athleteStats) {
        // PHP ASSOC ARRAY DESTRUCTURING
        
        ['all_ride_totals'=>$all_ride_totals, 'ytd_ride_totals'=>$ytd_ride_totals,
        'all_run_totals'=>$all_run_totals, 'ytd_run_totals'=>$ytd_run_totals,
        'all_swim_totals'=>$all_swim_totals, 'ytd_swim_totals'=>$ytd_swim_totals] = $athleteStats;
        // CAN BE CHNAGED WHEN SIGN UP IS ADDED AS athleteStats WILL BE SET ON SIGN UP
        // $userRowIsSet = $this->getAthleteStats($userId);
        
        // if($userRowIsSet) {
        //     
        // } else {
        //     $sql = "INSERT INTO athleteStats (userId, rideAllTimeDist, rideYearDist, runAllTimeDist, runYearDist, swimAllTimeDist, swimYearDist)
        //     VALUES ($userId, $all_ride_totals, $ytd_ride_totals, $all_run_totals, $ytd_run_totals, $all_swim_totals, $ytd_swim_totals)";

        // }
        echo json_encode($userId);
        $sql = "INSERT INTO athleteStats (userId, rideAllTimeDist, rideYearDist, runAllTimeDist, runYearDist, swimAllTimeDist, swimYearDist)
                 VALUES ('$userId', $all_ride_totals, $ytd_ride_totals, $all_run_totals, $ytd_run_totals, $all_swim_totals, $ytd_swim_totals)";
        $this->insertIntoDatabase($sql);
    }

    public function updateAthleteStats($userId, $athleteStats) {
        ['all_ride_totals'=>$all_ride_totals, 'ytd_ride_totals'=>$ytd_ride_totals,
        'all_run_totals'=>$all_run_totals, 'ytd_run_totals'=>$ytd_run_totals,
        'all_swim_totals'=>$all_swim_totals, 'ytd_swim_totals'=>$ytd_swim_totals] = $athleteStats;

        $sql = "UPDATE athleteStats SET rideAllTimeDist = $all_ride_totals, rideYearDist = $ytd_ride_totals,
              runAllTimeDist = $all_run_totals, runYearDist = $ytd_run_totals, 
              swimAllTimeDist = $all_swim_totals, swimYearDist = $ytd_swim_totals WHERE userId='$userId'";

        $this->insertIntoDatabase($sql);

    }

    public function test($userId, $athleteStats) {
        ['all_ride_totals'=>$all_ride_totals, 'ytd_ride_totals'=>$ytd_ride_totals,
        'all_run_totals'=>$all_run_totals, 'ytd_run_totals'=>$ytd_run_totals,
        'all_swim_totals'=>$all_swim_totals, 'ytd_swim_totals'=>$ytd_swim_totals] = $athleteStats;
        echo json_encode($all_ride_totals);

    }

    public function getAccessToken ($userId) {
        $accessToken = $this->getOneColum('athlete', 'accessToken', $userId);
        return $accessToken[0]['accessToken'];
    }

    public function getStravaAthleteId($userId) {
        $stravaAthleteId = $this->getOneColum('athlete', 'stravaAthleteId', $userId); 
        return $stravaAthleteId[0]['stravaAthleteId'];
    }

}
?>