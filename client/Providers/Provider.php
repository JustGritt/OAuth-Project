<?php

namespace Sdk\Providers;

abstract class Provider {

    
    abstract static function getState();
    abstract static function getName();
    abstract static function getScope();
    abstract static function getBaseAuthorizationUrl();
    //abstract static function getGrantType();

    public function getclientId() {
        return $this->client_id;
    }

    public function getClientSecret() {
        return $this->client_secret;
    }

    public function getAuthorizationUrl()
    {
        $queryParams= http_build_query([
            'client_id' => $this->getClientId(),
            'redirect_uri' => 'http://localhost:8081/callback',
            'response_type' => 'code',
            'scope' => $this->getScope(),
            // "state" => bin2hex(random_bytes(16))
            'state' => $this->getState()
        ]);
        $link = $this->getBaseAuthorizationUrl() . $queryParams;
        return $link;
    }

    public function getAccessToken()
    {
        $queryParams= http_build_query([
            'client_id' => $this->getClientId(),
            'client_secret' => $this->getClientSecret(),
            'redirect_uri' => 'https://www.google.fr',
            'grant_type' => 'authorization_code',
            'code' => $_GET['code']
        ]);
        $link = $this->getBaseAccessTokenUrl() . $queryParams;
        var_dump($link);
        
        $context_options = array (
            'http' => array (
                'method' => 'POST',
                'header'=> "Content-type: application/x-www-form-urlencoded\r\n"
                    . "Content-Length: " . strlen($queryParams) . "\r\n",
                    'content' => $queryParams
                    )
            );
        var_dump($context_options);
        
        $context = stream_context_create($context_options);
        var_dump($context);

        $response = file_get_contents($this->getBaseAccessTokenUrl() . $queryParams, false, $context);        
        return $response;
    }
}
