<?php

namespace Sdk\Providers;
use Sdk\ProviderInterface;
use Sdk\ProviderFactory;


class Google extends Provider implements ProviderInterface
{
    protected $client_id;
    protected $base_uri;
    protected $client_secret;
    protected $redirect_uri;
    protected $provider;
    protected $scope = [];
    protected $state;

    public function __construct($provider, $client_id, $client_secret, $redirect_uri)
    {
        $this->provider =  $provider; 
        $this->client_id = $client_id;
        $this->client_secret = $client_secret;
        $this->redirect_uri = $redirect_uri;
        $this->base_uri = "https://accounts.google.com/o/oauth2/v2/auth?";
        $this->scope = implode(" ", [
            "https://www.googleapis.com/auth/userinfo.profile https://www.googleapis.com/auth/userinfo.email"
        ]);
        $this->state = "Google";

        // $this->scope = ('https://www.googleapis.com/auth/userinfo.profile');
    }
    
}
