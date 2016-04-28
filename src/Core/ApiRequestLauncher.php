<?php

namespace Zoho\CRM\Core;

class ApiRequestLauncher
{
    const BASE_URI = 'https://crm.zoho.com/crm/private/';

    private static $initialized = false;

    private static $http_client;

    public static function initialize()
    {
        if (self::$initialized) return;

        self::$http_client = new \GuzzleHttp\Client([
            'base_uri' => self::BASE_URI
        ]);

        self::$initialized = true;
    }

    public static function fire(Request $request)
    {
        $response = self::$http_client->request($request->getHttpVerb(), $request->buildUri());
        return $response->getBody()->getContents();
    }
}

// Auto-initialization of the static class, once for all. Much handy. Such smoothness. Wow.
ApiRequestLauncher::initialize();
