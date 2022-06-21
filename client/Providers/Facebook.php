<?php

namespace Sdk\Providers;
use Sdk\ProviderInterface;
use Sdk\ProviderFactory;

class Facebook extends ProviderFactory implements ProviderInterface
{
    protected $client_id;
    protected $client_secret;
    protected $redirect_uri;
    protected $provider;

    public function __construct($provider, $client_id, $client_secret, $redirect_uri)
    {
        $this->provider =  $provider; 
        $this->client_id = $client_id;
        $this->client_secret = $client_secret;
        $this->redirect_uri = $redirect_uri;
    }

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
