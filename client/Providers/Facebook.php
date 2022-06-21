<?php

namespace Sdk\Providers;
use Sdk\ProviderInterface;
use Sdk\ProviderFactory;

class Facebook extends Provider implements ProviderInterface
{
    protected $client_id;
    protected $base_uri;
    protected $client_secret;
    protected $redirect_uri;
    protected $provider;
    protected $scope = [];

    public function __construct($provider, $client_id, $client_secret, $redirect_uri)
    {
        $this->provider =  $provider; 
        $this->client_id = $client_id;
        $this->client_secret = $client_secret;
        $this->redirect_uri = $redirect_uri;
        $this->base_uri = "https://www.facebook.com/v2.10/dialog/oauth?";
        $this->scope = implode(" ", [
            "user",
            "email"
        ]);
    }

}
