<?php 
class CurlSettings
{
    private $baseUrl = 'https://www.strava.com/api/v3/';

    public function __construct($urlEndpoint, $headers)
    {
        $this->urlEndpoint = $urlEndpoint;
        $this->headers = $headers;
    }

    protected function curlInit()
    {
        $curlInit = curl_init();

        curl_setopt($curlInit, CURLOPT_RETURNTRANSFER, true);

        if (count($this->headers) !== 0) {
            curl_setopt($curlInit, CURLOPT_HTTPHEADER, $this->headers);
        }


        curl_setopt($curlInit, CURLOPT_URL, $this->baseUrl . $this->urlEndpoint);

        $result = curl_exec($curlInit);

        curl_close($curlInit);

        return $result;
    }

    protected function curlPost($postfields) {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL,"https://www.strava.com/api/v3/oauth/token");
        curl_setopt($ch, CURLOPT_POST, 1);
        // curl_setopt($ch, CURLOPT_POSTFIELDS,
                    // "client_id=94702&client_secret=cc7de5dea65e248c912898647081be8a10bc2291&grant_type=refresh_token&refresh_token=bfb54d055b2b615e5b561c05f806661f05857330");

        // In real life you should use something like:
        curl_setopt($ch, CURLOPT_POSTFIELDS, 
                 http_build_query($postfields));

        // Receive server response ...
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $server_output = curl_exec($ch);

        curl_close ($ch);

        return $server_output;
    }
}

    
?>