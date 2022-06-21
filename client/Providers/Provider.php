<?php

namespace Sdk\Providers;

abstract class Provider {

    
    public function getProvider()
    {
        return $this;
    }

    public function getName()
    {
        echo "Creating Facebook provider..." . $this->provider;
        return $this->provider;
    }

    public function getClientId()
    {
        return $this->client_id;
    }

    public function getClientSecret()
    {
        return $this->client_secret;
    }

    public function getScope()
    {
        return $this->scope;
    }

    public function getAuthorizationUrl()
    {
        return  $queryParams= http_build_query([
            'client_id' => $this->getClientId(),
            'redirect_uri' => 'http://localhost:8081/callback',
            'response_type' => 'code',
            'scope' => $this->getScope(),
            "state" => bin2hex(random_bytes(16))
        ]);
    }

    public function setDefaultScope(){
        if(isset($this->scope ) && empty($this->scope)){
            throw new Exception("Error Processing Request", 1);

        }
    }

}
