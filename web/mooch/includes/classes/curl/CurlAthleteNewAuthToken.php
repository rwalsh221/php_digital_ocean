<?php 
require_once("CurlSettings.php");

class CurlAthleteNewAuthToken extends CurlSettings
{
    public function getNewAuthToken($clientId, $clientSecret, $refreshToken)
    {
        $postFields = [
            'client_id'=>$clientId,
            'client_secret'=>$clientSecret,
            'grant_type'=>'refresh_token',
            'refresh_token'=>$refreshToken
        ];
        $stravaApiCallJson = $this->curlPost($postFields);

        $stravaApiCallDecode = json_decode($stravaApiCallJson, true);

        return $stravaApiCallDecode;
    }
}
?>