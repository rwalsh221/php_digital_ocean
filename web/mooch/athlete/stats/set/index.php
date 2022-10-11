<?php
header("Access-Control-Allow-Origin: *");

require dirname(__DIR__, 3) . '/includes/classes/curl/CurlAthleteStats.php';
require dirname(__DIR__, 3) . '/includes/classes/curl/CurlAthleteNewAuthToken.php';

require dirname(__DIR__, 3) . '/includes/classes/database/DatabaseAthlete.php';

$userId = $_GET['userId'];

$databaseAthlete = new DatabaseAthlete();

$tokenExpiresAt = $databaseAthlete->getTokenExpiresAt($userId);
// ADD 5 MINS TO CURRENT TIME SO TOKEN EXPIRES EARLY
$currentTimePlus5Min = time() + 300;

if ($tokenExpiresAt <= $currentTimePlus5Min) {
       
        $clientSecret = $databaseAthlete->getClientSecret($userId);
        $clientId = $databaseAthlete->getClientId($userId);
        $refreshToken = $databaseAthlete->getRefreshToken($userId);
    
        $postFields = [
            'client_id'=>$clientId,
            'client_secret'=>$clientSecret,
            'grant_type'=>'refresh_token',
            'refresh_token'=>$refreshToken
        ];
        
        $curlAthleteNewAuthToken = new CurlAthleteNewAuthToken("oauth/token", array('Content-Type: application/json', 'client_id=94702',
        'client_secret=cc7de5dea65e248c912898647081be8a10bc2291', 'grant_type=refresh_token', 'refresh_token=bfb54d055b2b615e5b561c05f806661f05857330'));
        $newAccessToken = $curlAthleteNewAuthToken->getNewAuthToken($clientId, $clientSecret, $refreshToken);
        var_dump($newAccessToken);
        $databaseAthlete->setNewAccessToken($userId, $newAccessToken['access_token'], $newAccessToken['refresh_token'], 
        $newAccessToken['expires_at'], $newAccessToken['expires_in']);
    } 

$accessToken = $databaseAthlete->getAccessToken($userId);
$stravaAthleteId = $databaseAthlete->getStravaAthleteId($userId);

$curlAthleteStats = new CurlAthleteStats('athletes/' . $stravaAthleteId . '/stats', array(
    'Content-Type: application/json', 'Authorization: Bearer ' . $accessToken));

$curlAthleteStats = $curlAthleteStats->getAthleteStats();

$databaseAthlete->updateAthleteStats($userId, $curlAthleteStats);


?>