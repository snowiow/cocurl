<?php

namespace COCUrl;

class League
{
    /**
     * @vcom int unqiue identifier
     */
    public $id;

    /**
     * @var string league name
     */
    public $name;

    /**
     * @var array associative array with URLs to the league icons in different
     * sizes
     */
    public $icon_urls;

    private function __construct()
    {

    }

    public static function create(array $data)
    {
        $league            = new League();
        $league->id        = $data['id'];
        $league->name      = $data['name'];
        $league->icon_urls = $data['iconUrls'];

        return $league;
    }
}
