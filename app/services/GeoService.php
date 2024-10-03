<?php

namespace App\services;

use GuzzleHttp\Client;

class GeoService
{
    protected $client;

    public function __construct()
    {
        $this->client = new Client();
    }

    public function getLocation($ip)
    {
        $response = $this->client->get("http://ipinfo.io/{$ip}/json");
        return json_decode($response->getBody()->getContents(), true);
    }
}
