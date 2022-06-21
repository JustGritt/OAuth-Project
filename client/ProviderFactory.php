<?php 

namespace Sdk;
abstract class ProviderFactory
{
    /**
     * @param string $provider
     * @param string $client_id
     * @param string $client_secret
     * @param string $redirect_uri
     */
    public static function create($provider, $client_id, $client_secret, $redirect_uri)
    {
        
        $reflection =  new \ReflectionClass("Sdk\Providers\\" .$provider);
        if (!$reflection->implementsInterface('Sdk\ProviderInterface')){
            throw new \RuntimeException("Class '$provider' does not implement ProviderInterface");
        }
        $className = "Sdk\\Providers\\" . ucfirst($provider);
        return new $className($provider, $client_id, $client_secret, $redirect_uri);
        
    }
}