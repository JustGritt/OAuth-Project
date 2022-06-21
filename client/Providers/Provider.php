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

    public function getRedirectUri()
    {
        return $this->redirect_uri;
    }
}