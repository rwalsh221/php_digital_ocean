<?php 

class CurlRegisterAthlete {
    public function __construct($clientId, $clientSecret, $authCode)
    {
        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
        $this->authCode = $authCode;
    }

    public function getTokenReadAll()
    {
        $postArray = [
            'client_id' => $this->clientId,
            'client_secret' => $this->clientSecret,
            'code'   => $this->authCode,
            'grant_type' => 'authorization_code'
            ];

        $ch = curl_init('https://www.strava.com/oauth/token');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postArray);

        // execute!
        $response = curl_exec($ch);

        // close the connection, release resources used
        curl_close($ch);

        return $response;
    }

};
   

?>