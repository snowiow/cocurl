<?php

namespace COCUrl;

class Client
{
    /**
     * @var string
     */
    const LEAGUES_URL = 'https://api.clashofclans.com/v1/leagues';

    /**
     * Access Token to get into the coc api
     * @var string
     */
    private $accessToken;

    /**
     * The options used for the curl header
     * @var array
     */
    private $curlHeader = [
        'Accept: application/json',
    ];

    /**
     * The curl client
     * @var resource
     */
    private $curlClient;

    /**
     * Client CTor.
     * @param string $access_token A valid access token to access the Clash of
     * Clans API
     */
    public function __construct(string $accessToken)
    {
        $this->accessToken  = $accessToken;
        $this->curlHeader[] = 'Authorization: Bearer ' . $this->accessToken;
    }

    public function getAccessToken()
    {
        return $this->accessToken;
    }

    /**
     * Returns all the leagues available in Clash of Clans. Calls the API at
     * /leagues
     * @return array of leagues currently available in Clash of Clans
     */
    public function leagues(): array
    {
        $this->curlClient = curl_init(self::LEAGUES_URL);
        curl_setopt($this->curlClient, CURLOPT_HTTPHEADER, $this->curlHeader);
        curl_setopt($this->curlClient, CURLOPT_RETURNTRANSFER, true);
        $results = json_decode(curl_exec($this->curlClient), true);
        $leagues = [];
        foreach ($results['items'] as $result) {
            $leagues[] = League::create($result);
        }
        return $leagues;
    }
}
