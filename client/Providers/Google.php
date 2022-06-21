<?php

namespace Sdk\Providers;
use Sdk\ProviderInterface;
use Sdk\ProviderFactory;


class Google extends Provider implements ProviderInterface
{
    protected $client_id;
    protected $client_secret;
    protected $redirect_uri;

    public function __construct( $client_id, $client_secret, $redirect_uri)
    {
        $this->client_id = $client_id;
        $this->client_secret = $client_secret;
        $this->redirect_uri = $redirect_uri;
    }
    
    public static function getBaseAuthorizationUrl()
    {
        return "https://accounts.google.com/o/oauth2/v2/auth?";
    }

    public static function getName()
    {
        return "Google";
    }

    public static function getState()
    {
        return "Google";
    }

    public static function getScope()
    {
        return implode(" ", [
            "https://www.googleapis.com/auth/userinfo.profile https://www.googleapis.com/auth/userinfo.email"
        ]);
    }
}
