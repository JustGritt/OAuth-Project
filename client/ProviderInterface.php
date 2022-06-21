<?php
namespace Sdk;


interface ProviderInterface
{
    public function getBaseUri();
    public function getName();
    public function getClientId();
    public function getClientSecret();
    public function setDefaultScope();
}