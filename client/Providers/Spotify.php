<?php

namespace Sdk\Providers;
use Sdk\ProviderInterface;
use Sdk\ProviderFactory;


class Spotify extends Provider implements ProviderInterface
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
        return "https://accounts.spotify.com/authorize?";
    }

    //TODO: Implement getBaseAccessTokenUrl()
    public static function getBaseAccessTokenUrl()
    {
        return "https://accounts.spotify.com/api/token?";
    }

    public static function getBaseMeUrl()
    {
        return "https://api.spotify.com/v1/me?";
    }


    public static function getName()
    {
        return "Spotify";
    }

    public static function getState()
    {
        return "Spotify";
    }

    public static function getScope()
    {
        return implode(" ", [
            "user-read-email",
            "user-read-private"
        ]);
    }

    /*
    
    public function validateToken($token)
    {
        $access_token = $token['access_token'];
        $context = stream_context_create([
            'http' => [
                'header' => "Authorization: Bearer {$access_token}"
                ]
            ]);
        $response = file_get_contents('https://api.spotify.com/v1/me?', false, $context);
        $user = json_decode($response, true);

        return $user;
    }*/
    
}
