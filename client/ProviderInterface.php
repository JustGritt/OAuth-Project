<?php
namespace Sdk;


interface ProviderInterface
{
    public static function getName();
    public static function getState();
    public static function getScope();
    public static function getBaseAuthorizationUrl();
    public function getClientId();
    //public static function getGrantType();
}