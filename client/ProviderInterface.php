<?php
namespace Sdk;


interface ProviderInterface
{
    public function getProvider();
    public function getName();
    public function getClientId();
    public function getClientSecret();
    public function getRedirectUri();
}