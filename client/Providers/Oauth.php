<?php

namespace Sdk\Providers;
use Sdk\ProviderInterface;
use Sdk\ProviderFactory;


class Oauth extends Provider implements ProviderInterface
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
        return "http://localhost:8080/auth?";
    }

    public static function getBaseAccessTokenUrl()
    {
        return "http://server:8080/token?";
    }

    public static function getBaseMeUrl()
    {
        return "http://server:8080/me";
    }

    public static function getName()
    {
        return "Oauth";
    }

    public static function getState()
    {
        return "Oauth";
    }

    public static function getScope()
    {
        return implode(" ", [
            "basic"
        ]);
    }

}
