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

    public function testClansByFilter()
    {
        $ed_clan_tag = '#28PU922';
        $params      = [
            'name'         => 'Eternal Deztiny',
            'warFrequency' => COCUrl\WarFrequency::ALWAYS,
            'locationId'   => 32000006, //International Code of COC API
            'minMembers'   => 2,
            'maxMembers'   => 50,
            'minClanLevel' => 9,
            'limit'        => 5,
        ];
        $cocUrl  = new COCUrl\Client(file_get_contents('my_key.txt'));
        $results = $cocUrl->clans($params);

        $this->assertTrue(count($results) > 0);
        $this->assertEquals($params['name'], $results[0]->name);
        $this->assertEquals($ed_clan_tag, $results[0]->tag);
        $this->assertEquals($params['locationId'], $results[0]->location->id);
    }

    public function testClansByid()
    {
        $ed_clan_tag               = '#28PU922';
        $international_location_id = 32000006; //International Code of COC API
        $cocUrl                    = new COCUrl\Client(file_get_contents('my_key.txt'));
        $result                    = $cocUrl->clans($ed_clan_tag);

        $this->assertEquals('COCUrl\Clan', get_class($result));
        $this->assertEquals('Eternal Deztiny', $result->name);
        $this->assertEquals($ed_clan_tag, $result->tag);
        $this->assertEquals($international_location_id, $result->location->id);
    }

    public function testClansByMembersOnly()
    {
        $ed_clan_tag               = '#28PU922';
        $international_location_id = 32000006; //International Code of COC API
        $cocUrl                    = new COCUrl\Client(file_get_contents('my_key.txt'));
        $results                   = $cocUrl->clans($ed_clan_tag, true);

        $this->assertTrue(is_array($results));
        $this->assertEquals('COCUrl\Player', get_class($results[0]));
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

    public function testLocationsWithIdAndRankForClans()
    {
        $germany_id = 32000094;
        $rank       = COCUrl\RankingId::CLANS;
        $cocUrl     = new COCUrl\Client(file_get_contents('my_key.txt'));
        $clans      = $cocUrl->locations($germany_id, $rank);
        $this->assertNotEmpty($clans);
        $this->assertEquals('COCUrl\Clan', get_class($clans[0]));
        $this->assertEquals('COCUrl\Location', get_class($clans[0]->location));
        $this->assertEquals($germany_id, $clans[0]->location->id);
    }

    public function testLocationsWithIdAndRankForPlayers()
    {
        $germany_id = 32000094;
        $rank       = COCUrl\RankingId::PLAYERS;
        $cocUrl     = new COCUrl\Client(file_get_contents('my_key.txt'));
        $players    = $cocUrl->locations($germany_id, $rank);
        $this->assertNotEmpty($players);
        $this->assertEquals('COCUrl\Player', get_class($players[0]));
        $this->assertEquals('COCUrl\Clan', get_class($players[0]->clan));
        $this->assertEquals('COCUrl\League', get_class($players[0]->league));
    }
}
