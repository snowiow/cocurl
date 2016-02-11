<?php

class ClanTest extends PHPUnit_Framework_TestCase
{
    /**
     * @expectedException Error
     */
    public function testConstructClan()
    {
        $clan = new \COCUrl\Clan();
    }

    public function testCreateEmptyClan()
    {
        $clan = \COCUrl\Clan::create([]);
        $this->assertEquals('COCUrl\Clan', get_class($clan));
    }

    public function testCreateFilledClan()
    {
        $fields = [
            'tag'      => 'abc',
            'name'     => 'clan name',
            'location' => [
                'id'          => 1,
                'name'        => 'America',
                'isCountry'   => true,
                'countryCode' => 'USA',
            ],
        ];

        $clan = \COCUrl\Clan::create($fields);
        $this->assertEquals($fields['tag'], $clan->tag);
        $this->assertEquals($fields['name'], $clan->name);
        $this->assertEquals('COCUrl\Location', get_class($clan->location));
        $this->assertEquals($fields['location']['name'], $clan->location->name);
    }
}
