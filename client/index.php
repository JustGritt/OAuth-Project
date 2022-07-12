<?php

namespace Sdk;
use Sdk\Providers;

function myAutoloader($class)
{
    $class = str_replace("Sdk\\","",$class);
    $class = str_replace("\\", "/",$class);
    if(!file_exists($class.".php")){
        throw new \RuntimeException("Class '$class' not found");
    }
    include $class.".php";
}

spl_autoload_register("Sdk\myAutoloader");

$config_file = "config.json";
if (!file_exists($config_file)) {
    throw new \RuntimeException("Config file '$config_file' not found");
}
$configs = json_decode(file_get_contents($config_file), true);
$factory  = new ProviderFactory();

// Initilisation of providers
foreach ($configs as $config => $value) {
    
    $provider = $config;
    $client_id = $value["client_id"];
    $client_secret = $value["client_secret"];
    $redirect_uri = $value["redirect_uri"];
    $factory->create($provider, $client_id, $client_secret, $redirect_uri);
}

function login($factory)
{
    echo "
        <form action='/callback' method='post'>
            <input type='text' name='username'/>
            <input type='password' name='password'/>
            <input type='submit' value='Login'/>
        </form>
    ";

    $providers = $factory->getProviders();
    foreach($providers as $provider){
        echo "<pre>";
        echo "<a href=\" {$provider->getAuthorizationUrl()} \">Login with " . $provider->getName() . "</a><br>";
        echo "</pre>";
    }

}

function callback($factory)
{
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $provider = $factory->getProvider("Oauth");
        $token = $provider->getAccessToken();
        $result = $provider->validateToken($token);
        
        return $provider->toString($result);
    }
    // No need to switch state, because we instanciate the correct provider in the factory
    $provider = $factory->getProvider($_GET["state"]);
    $token = $provider->getAccessToken();
    $result = $provider->validateToken($token);
    $provider->toString($result);
}

$route = $_SERVER["REQUEST_URI"];
switch (strtok($route, "?")) {
    case '/login':
        login($factory);
        break;
    case '/callback':
        callback($factory);
        break;
    default:
        http_response_code(404);
        break;
}
