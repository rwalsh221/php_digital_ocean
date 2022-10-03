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
}

    
?>