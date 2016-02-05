<?php

class LeagueTest extends PHPUnit_Framework_TestCase
{
    /**
     * @expectedException Error
     */
    public function testConstructLeague()
    {
        $league = new \COCUrl\League();
    }

    public function testCreateEmptyLeague()
    {
        $league = \COCUrl\League::create([]);
        $this->assertTrue(get_class($league) === 'COCUrl\League');
    }

    public function testCreateFilledLeage()
    {
        $fields = [
            'id'       => 1,
            'name'     => 'Ranked',
            'iconUrls' => [
                'small'  => 'small.png',
                'medium' => 'medium.png',
            ],
        ];

        $league = \COCUrl\League::create($fields);
        $this->assertEquals($fields['id'], $league->id);
        $this->assertEquals($fields['name'], $league->name);
        $this->assertEquals($fields['iconUrls'], $league->iconUrls);
    }
}
