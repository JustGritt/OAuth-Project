<?php 

namespace Sdk;

class ProviderFactory
{
    protected $providers = [];
    /**
     * @param string $provider
     * @param string $client_id
     * @param string $client_secret
     * @param string $redirect_uri
     */
    public function create($provider, $client_id, $client_secret, $redirect_uri)
    {
        $reflection =  new \ReflectionClass("Sdk\Providers\\" .$provider);

        if (!$reflection->implementsInterface('Sdk\ProviderInterface')){
            throw new \RuntimeException("Class '$provider' does not implement ProviderInterface");
        }

        $className = "Sdk\\Providers\\" . ucfirst($provider);
        $provider = new $className($client_id, $client_secret, $redirect_uri);
        $this->providers[] = $provider;

        return $provider;
    }

    
    public function getProviders()
    {
        return $this->providers;
    }

    public function getProvider($name)
    {
        foreach ($this->providers as $provider) {
            if ($provider->getName() == $name) {
                return $provider;
            }
        }
        throw new \RuntimeException("Provider '$name' not found");
    }
}