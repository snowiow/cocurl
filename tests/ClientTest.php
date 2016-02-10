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
    }

    public function testLocations()
    {
        $cocUrl  = new COCUrl\Client(file_get_contents('my_key.txt'));
        $results = $cocUrl->locations();
        $found   = array_search('Germany', array_column($results, 'name'));
        $this->assertTrue($found > 0);
    }

    public function testLocationsWithId()
    {
        $germany_id = 32000094;
        $cocUrl     = new COCUrl\Client(file_get_contents('my_key.txt'));
        $location   = $cocUrl->locations($germany_id);
        $this->assertEquals($germany_id, $location->id);
        $this->assertEquals('Germany', $location->name);
        $this->assertTrue(true, $location->isCountry);
        $this->assertEquals('DE', $location->countryCode);
    }
}
