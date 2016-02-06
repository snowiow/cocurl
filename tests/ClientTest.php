<?php

class ClientTest extends PHPUnit_Framework_TestCase
{
    public function testConstructor()
    {
        $apiKey = 'abc.def.geh';
        $client = new COCUrl\Client($apiKey);
        $this->assertEquals($apiKey, $client->getAccessToken());
    }

    public function testLeagues()
    {
        $cocUrl  = new COCUrl\Client(file_get_contents('my_key.txt'));
        $results = $cocUrl->leagues();
        $this->assertNotEmpty($results);
        $this->assertEquals('Unranked', $results[0]->name);
    }

    public function testClans()
    {
        $param_arr = [
            'name'         => 'Eternal Deztiny',
            'warFrequency' => COCUrl\WarFrequency::ALWAYS,
            'locationId'   => 32000006, //International Code of COC API
            '',
        ];
        $cocUrl  = new COCUrl\Client(file_get_contents('my_key.txt'));
        $results = $cocUrl->clans($param_arr);
        var_dump($results);
    }
}
