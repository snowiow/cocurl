<?php

namespace COCUrl;

/**
 * The league class holds the league specific data of the coc api
 */
final class League extends COCEntity
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
    public $iconUrls;

    private function __construct()
    {
    }

    /**
     * Creates a league object with the given data
     * @param array $data an associative array to fill up the members of the
     * league class
     * @return League a league object with the data given as it's members
     */
    public static function create(array $data): League
    {
        $league = new League();
        parent::fill($data, $league);
        return $league;
    }
}
