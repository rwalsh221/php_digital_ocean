<?php
header("Access-Control-Allow-Origin: *");

require dirname(__DIR__, 3) . '/includes/classes/curl/CurlAthleteStats.php';
require dirname(__DIR__, 3) . '/includes/classes/database/DatabaseAthlete.php';

$userId = $_GET['userId'];

$databaseAthlete = new DatabaseAthlete();

$accessToken = $databaseAthlete->getAccessToken($userId);
$stravaAthleteId = $databaseAthlete->getStravaAthleteId($userId);

$curlAthleteStats = new CurlAthleteStats('athletes/' . $stravaAthleteId . '/stats', array(
    'Content-Type: application/json', 'Authorization: Bearer ' . $accessToken));

$curlAthleteStats = $curlAthleteStats->getAthleteStats();


$databaseAthlete->updateAthleteStats($userId, $curlAthleteStats);


?>