<?php 
require_once('DatabaseSettings.php');

class DatabaseSegments extends DatabaseSettings {
    public function getSegmentIds() {
        $sql = 'SELECT segmentId FROM segments';

        return $this->getFromDatabase($sql);

    }

    public function updateUserSegmentTime($segmentId, $userId, $segmentTime) {
        $sql = "SELECT segmentTime from segmentTimes WHERE segmentId='$segmentId' AND userId='$userId'";

        $result = $this->getFromDatabase($sql);
        // var_dump($result[0]['segmentTime']);
    
        if(empty($result)) {
            // INSERT INTO
            $sql = "INSERT INTO segmentTimes (userId, segmentId, segmentTime)
            VALUES ('$userId', '$segmentId', '$segmentTime')";

            $this->insertIntoDatabase($sql);

        } else if ($segmentTime < $result[0]['segmentTime']) {
            // UPDATE
            $sql = "UPDATE segmentTimes SET segmentTime='$segmentTime' WHERE segmentId='$segmentId' AND userId='$userId'";

            $this->insertIntoDatabase($sql);
        }
    }

    public function getAthleteSegments($userId) {
        $sql = "SELECT segmentId from segmentTimes WHERE userId='$userId'";

        $result = $this->getFromDatabase($sql);
       
        $athleteSegments = array();

        foreach($result as $segmentId) {
            
            $segmentId=$segmentId['segmentId'];

            $sql = "SELECT * from segments WHERE segmentId='$segmentId'";

            $result = $this->getFromDatabase($sql);

            array_push($athleteSegments, $result);
        }
            // var_dump($athleteSegments);
        return $athleteSegments;
    }

    // public function getSegmentTimes($segmentId) {
    //     $sql = "SELECT segmentTime, userId from segmentTimes WHERE segmentId='$segmentId'";

    //     return $this->getFromDatabase($sql);
    // }

    public function getSegmentAthlete($segmentId) {
        $sql = "SELECT userId from segmentTimes WHERE segmentId='$segmentId'";

        $userIds = $this->getFromDatabase($sql);

        $userNameArray = array();

        foreach($userIds as $userId) {

        }
    }


    public function getSegmentTimes3($segmentId) {
        $sql = "SELECT segmentTime, userId FROM segmentTimes WHERE segmentId = '$segmentId' ORDER BY segmentTime ASC";

        return $this->getFromDatabase($sql);
    }

    public function getSegmentTimes($athleteSegments) {
        $segmentTimesArray = array();
        // var_dump($athleteSegments);
        foreach ($athleteSegments as $athleteSegmentsKey) {
            
        $segmentId = $athleteSegmentsKey[0]['segmentId'];
        // var_dump($segmentId);
        $sql = "SELECT segmentTime, userId FROM segmentTimes WHERE segmentId = '$segmentId' ORDER BY segmentTime ASC";

        $segmentTimes = $this->getFromDatabase($sql);
            // var_dump($segmentTimes);
            foreach($segmentTimes as $segmentTimesKey) {
                
                $time = $segmentTimesKey['segmentTime'];
                $userId = $segmentTimesKey['userId'];
                $name = $this->getAthleteName($segmentTimesKey['userId'])[0]['firstName']; // METHOD RETURNS ARRAY FROM DB
                
                $segmentTimesArray["$segmentId"]["$userId"]["name"]=$name;
                $segmentTimesArray["$segmentId"]["$userId"]["time"]=$time;
                
            }
        
        }

        // var_dump($segmentTimesArray);
        return $segmentTimesArray;
    }

    public function getAthleteSegmentsJson($userId) {
        // var_dump($userId);
        $athleteSegments = $this->getAthleteSegments($userId);
        $segmentTimes = $this->getSegmentTimes($athleteSegments);

        // var_dump($athleteSegments);
        // echo'<br>';
        // var_dump($segmentTimes);

        foreach ($athleteSegments as $key=>$athleteSegmentsKey) {
            // echo "$key";
            $segmentId = $athleteSegmentsKey[0]['segmentId'];
            $athleteSegments[$key]['segmentTimes'] = $segmentTimes["$segmentId"];
        }
        // echo'<pre>';
        // var_dump($athleteSegments);
        // echo'</pre>';

        

        return $athleteSegments;
    }

    public function getAthleteName($userId) {
        $sql = "SELECT firstName FROM athlete WHERE userId = '$userId'";

        return $this->getFromDatabase($sql);
    }



}
?>