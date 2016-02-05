<?php

class COCUrlTest extends PHPUnit_Framework_TestCase
{
    public function testLeagues()
    {
        $coc_url = new COCUrl\Client(file_get_contents('my_key.txt'));
        $results = $coc_url->leagues();
        $this->assertNotEmpty($results);
        $this->assertEquals('Unranked', $results[0]->name);
    }
}
