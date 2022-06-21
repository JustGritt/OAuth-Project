<?php

namespace Sdk;
use Sdk\Providers;
//require "config.json";

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
$configs = json_decode(file_get_contents($config_file), true);
$factory  = new ProviderFactory();
echo "<pre>";
foreach ($configs as $config => $value) {
    
    $provider = $config;
    $client_id = $value["client_id"];
    $client_secret = $value["client_secret"];
    $redirect_uri = $value["redirect_uri"];
    $factory->create($provider, $client_id, $client_secret, $redirect_uri);
}
echo "</pre>";

// echo "<pre>";
// $providers = $factory->getProviders();

// foreach($providers as $provider){
//     echo "<pre>";
//     echo $provider->getBaseUri() . $provider->getAuthorizationUrl() . "\n";
//     echo "</pre>";
// }
// echo "</pre>";

function login($factory)
{
    // $queryParams= http_build_query([
    //     'client_id' => OAUTH_CLIENT_ID,
    //     'redirect_uri' => 'http://localhost:8081/callback',
    //     'response_type' => 'code',
    //     'scope' => 'basic',
    //     "state" => bin2hex(random_bytes(16))
    // ]);
    echo "
        <form action='/callback' method='post'>
            <input type='text' name='username'/>
            <input type='password' name='password'/>
            <input type='submit' value='Login'/>
        </form>
    ";
    // echo "<a href=\"http://localhost:8080/auth?{$queryParams}\">Login with OauthServer</a><br>";
    // $queryParams= http_build_query([
    //     'client_id' => FACEBOOK_CLIENT_ID,
    //     'redirect_uri' => 'http://localhost:8081/fb_callback',
    //     'response_type' => 'code',
    //     'scope' => 'public_profile,email',
    //     "state" => bin2hex(random_bytes(16))
    // ]);
    // echo "<a href=\"https://www.facebook.com/v2.10/dialog/oauth?{$queryParams}\">Login with Facebook</a>";

    $providers = $factory->getProviders();
    foreach($providers as $provider){

        echo "<pre>";
        // var_dump($provider->getBaseUri() . $provider->getAuthorizationUrl() . "\n");
        $link = $provider->getBaseUri() . $provider->getAuthorizationUrl();
        // var_dump(urlencode('https://www.googleapis.com/auth/userinfo.profile https://www.googleapis.com/auth/userinfo.email%27'));
        echo "<a href=\" $link \">Login with " . $provider->getName() . "</a><br>";
        
        echo "</pre>";
    }

}

// Exchange code for token then get user info
function callback()
{
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        ["username" => $username, "password" => $password] = $_POST;
        $specifParams = [
            'username' => $username,
            'password' => $password,
            'grant_type' => 'password',
        ];
    } else {
        ["code" => $code, "state" => $state] = $_GET;

        $specifParams = [
            'code' => $code,
            'grant_type' => 'authorization_code',
        ];
    }

    $queryParams = http_build_query(array_merge([
        'client_id' => OAUTH_CLIENT_ID,
        'client_secret' => OAUTH_CLIENT_SECRET,
        'redirect_uri' => 'http://localhost:8081/callback',
    ], $specifParams));
    $response = file_get_contents("http://server:8080/token?{$queryParams}");
    $token = json_decode($response, true);
    
    $context = stream_context_create([
        'http' => [
            'header' => "Authorization: Bearer {$token['access_token']}"
            ]
        ]);
    $response = file_get_contents("http://server:8080/me", false, $context);
    $user = json_decode($response, true);
    echo "Hello {$user['lastname']} {$user['firstname']}";
}

function fbcallback()
{
    ["code" => $code, "state" => $state] = $_GET;

    $specifParams = [
            'code' => $code,
            'grant_type' => 'authorization_code',
        ];

    $queryParams = http_build_query(array_merge([
        'client_id' => FACEBOOK_CLIENT_ID,
        'client_secret' => FACEBOOK_CLIENT_SECRET,
        'redirect_uri' => 'http://localhost:8081/fb_callback',
    ], $specifParams));
    $response = file_get_contents("https://graph.facebook.com/v2.10/oauth/access_token?{$queryParams}");
    $token = json_decode($response, true);
    
    $context = stream_context_create([
        'http' => [
            'header' => "Authorization: Bearer {$token['access_token']}"
            ]
        ]);
    $response = file_get_contents("https://graph.facebook.com/v2.10/me", false, $context);
    $user = json_decode($response, true);
    echo "Hello {$user['name']}";
}


$route = $_SERVER["REQUEST_URI"];
switch (strtok($route, "?")) {
    case '/login':
        login($factory);
        break;
    case '/callback':
        callback();
        break;
    case '/fb_callback':
        fbcallback();
        break;
    default:
        http_response_code(404);
        break;
}
