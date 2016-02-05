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
}
