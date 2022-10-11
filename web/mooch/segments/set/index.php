<?php 
require dirname(__DIR__, 2) . '/includes/classes/curl/CurlSegments.php';
require dirname(__DIR__, 2) . '/includes/classes/database/DatabaseSegments.php';
require dirname(__DIR__, 2) . '/includes/classes/database/DatabaseAthlete.php';

header("Access-Control-Allow-Origin: *");

$userId = $_GET['userId'];

$databaseAthlete = new DatabaseAthlete();

$accessToken = $databaseAthlete->getAccessToken($userId);

$databaseSegments = new DatabaseSegments();

$segments = $databaseSegments->getSegmentIds();

$segmentIdArray = array();
$segmentTimeArray = array();



foreach($segments as $segment) {
    array_push($segmentIdArray, $segment['segmentId']);
}

foreach($segmentIdArray as $segmentId) {
    $curlSegment = new CurlSegments('segments/' . $segmentId , array(
            'Content-Type: application/json', 'Authorization: Bearer ' . $accessToken));

    $segmentJson = $curlSegment->getSegment();

    $segmentJsonDecode = json_decode($segmentJson, true);

    $athleteSegmentTime = $segmentJsonDecode['athlete_segment_stats']['pr_elapsed_time'];

   if($athleteSegmentTime === null) {
    continue;
   };
   
   array_push($segmentTimeArray, ['segmentId'=>$segmentId,'segmentTime'=>$athleteSegmentTime]);

}

foreach($segmentTimeArray as $segmentTimeArrayIndex) {
    $databaseSegments->updateUserSegmentTime($segmentTimeArrayIndex['segmentId'], $userId, $segmentTimeArrayIndex['segmentTime']);
}

// $userSegments = $databaseConnection->getAthleteSegments($userId);

// echo json_encode($userSegments);

?>