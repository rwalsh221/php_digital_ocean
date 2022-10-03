<?php
header("Access-Control-Allow-Origin: *");

require dirname(__DIR__, 2) . '/includes/classes/database/DatabaseAthlete.php';
require dirname(__DIR__, 2) . '/includes/classes/curl/CurlAthleteStats.php';

$body = file_get_contents('php://input');
$data = json_decode($body, true);

$databaseAthlete = new DatabaseAthlete();

$databaseAthlete->registerAthlete($data['userId'] ,$data['email'] ,$data['athlete']['id'], $data['athlete']['firstname'],$data['athlete']['lastname'], $data['athlete']['profile_medium'], 
$data['expires_at'], $data['expires_in'], $data['clientId'], $data['clientSecret'], $data['access_token'], $data['refresh_token']);

$getAthleteStats = new CurlAthleteStats('athletes/' . $data['athlete']['id'] . '/stats', array(
    'Content-Type: application/json', 'Authorization: Bearer ' . $data['access_token']));

$athleteStats = $getAthleteStats->getAthleteStats();
echo json_encode($athleteStats);

$databaseAthlete->insertAthleteStats($data['userId'], $athleteStats);
// $databaseAthlete->test($data['userId'], $athleteStats);

// $initRegisterAthlete->registerAthlete('test1','test2','test3','test4',1,2,'test7','test8',)

// echo json_encode($data['athlete']['firstname']);
?>