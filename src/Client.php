<?php

namespace COCUrl;

class Client
{
    /**
     * @var string
     */
    const LEAGUES_URL = 'https://api.clashofclans.com/v1/leagues';

    /**
     * @var string
     */
    private $access_token;

    private $curl_header = [
        'Accept: application/json',
    ];

    private $curl_client;

    /**
     * COCUrl CTor.
     * @param string $access_token A valid access token to access the Clash of
     * Clans API
     */
    public function __construct(string $access_token)
    {
        $this->access_token  = $access_token;
        $this->curl_header[] = 'Authorization: Bearer ' . $this->access_token;
    }

    public function leagues(): array
    {
        $this->curl_client = curl_init(self::LEAGUES_URL);
        curl_setopt($this->curl_client, CURLOPT_HTTPHEADER, $this->curl_header);
        curl_setopt($this->curl_client, CURLOPT_RETURNTRANSFER, true);
        $results = json_decode(curl_exec($this->curl_client), true);
        $leagues = [];
        foreach ($results['items'] as $result) {
            $leagues[] = League::create($result);
        }
        return $leagues;
    }
}
