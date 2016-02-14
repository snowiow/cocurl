<?php

class PlayerTest extends PHPUnit_Framework_TestCase
{
    /**
     * @expectedException Error
     */
    public function testConstructPlayer()
    {
        $player = new \COCUrl\Player();
    }

    public function testCreateEmptyPlayer()
    {
        $player = \COCUrl\Player::create([]);
        $this->assertEquals('COCUrl\Player', get_class($player));
    }

    public function testPlayer()
    {
        $fields = [
            'name'         => 'name',
            'expLevel'     => 123,
            'trophies'     => 1234,
            'attackWins'   => 12,
            'defenseWins'  => 2,
            'rank'         => 1,
            'previousRank' => 3,
            'clan'         => [
                'tag'      => 'abc',
                'name'     => 'clan name',
                'location' => [
                    'id'          => 1,
                    'name'        => 'America',
                    'isCountry'   => true,
                    'countryCode' => 'USA',
                ],
            ],
            'league'       => [
                'id'       => 1,
                'name'     => 'Ranked',
                'iconUrls' => [
                    'small'  => 'small.png',
                    'medium' => 'medium.png',
                ],

            ],
        ];

        $player = \COCUrl\Player::create($fields);
        $this->assertEquals($fields['name'], $player->name);
        $this->assertEquals($fields['expLevel'], $player->expLevel);
        $this->assertEquals($fields['trophies'], $player->trophies);
        $this->assertEquals($fields['attackWins'], $player->attackWins);
        $this->assertEquals($fields['defenseWins'], $player->defenseWins);
        $this->assertEquals($fields['rank'], $player->rank);
        $this->assertEquals($fields['previousRank'], $player->previousRank);
        $this->assertEquals('COCUrl\Clan', get_class($player->clan));
        $this->assertEquals('COCUrl\League', get_class($player->league));
    }
}
