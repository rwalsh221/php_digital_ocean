<?php
header("Access-Control-Allow-Origin: *");

require dirname(__DIR__, 1) . '/includes/classes/curl/CurlAthlete.php';
require dirname(__DIR__, 1) . '/includes/classes/database/DatabaseAthlete.php';

$userId = $_GET['userId'];

$databaseConnection = new DatabaseAthlete();

$userInfo = $databaseConnection->getAthlete($userId);

echo json_encode($userInfo);

?>