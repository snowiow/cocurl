<?php
/**
 *  League Class
 */
namespace COCUrl;

/**
 * The league class holds the league specific data of the coc api
 */
final class League extends COCEntity
{
    /**
     * Unique identifier used by SuperCell
     */
    public $id;

    /**
     * Name of the League
     */
    public $name;

    /**
     * Array of URLs to different sizes of a league image
     */
    public $iconUrls;

    /**
     * Private CTor. League Objects will be created via the create method
     */
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
