<?php

class LocationTest extends PHPUnit_Framework_TestCase
{
    /**
     * @expectedException Error
     */
    public function testConstructLocation()
    {
        $location = new \COCUrl\Location();
    }

    public function testCreateEmptyLocation()
    {
        $location = \COCUrl\Location::create([]);
        $this->assertTrue(get_class($location) === 'COCUrl\Location');
    }

    public function testCreateFilledLocation()
    {
        $fields = [
            'id'        => 3,
            'name'      => 'Imaginary',
            'isCountry' => false,
        ];

        $location = \COCUrl\Location::create($fields);
        $this->assertEquals($fields['id'], $location->id);
        $this->assertEquals($fields['name'], $location->name);
        $this->assertEquals($fields['isCountry'], $location->isCountry);
    }

    public function testCreateFilledCountry()
    {
        $fields = [
            'id'          => 1,
            'name'        => 'America',
            'isCountry'   => true,
            'countryCode' => 'USA',
        ];

        $location = \COCUrl\Location::create($fields);
        $this->assertEquals($fields['id'], $location->id);
        $this->assertEquals($fields['name'], $location->name);
        $this->assertEquals($fields['isCountry'], $location->isCountry);
        $this->assertEquals($fields['countryCode'], $location->countryCode);
    }
}
