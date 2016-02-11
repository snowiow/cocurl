<?php

namespace COCUrl;

final class Clan extends COCEntity
{
    /**
     * The unqiue Clan Tag
     */
    public $tag;

    /**
     * Name of the Clan
     */
    public $name;

    /**
     * Location object, which holds the location information about this clan
     */
    public $location;

    /**
     * array of links wiht different sizes of the clan badge image
     */
    public $badgeURLs;

    /**
     * The level of the Clan
     */
    public $clanLevel;

    /**
     * how many members are currently in the clan
     */
    public $members;

    /**
     * How many trophy points does the clan have
     */
    public $clanPoints;

    /**
     * The current ladder rank of the clan
     */
    public $rank;

    /**
     * The ladder rank of the previous season
     */
    public $previousRank;

    /**
     * Private CTor. Clan Objects will be created via the create method
     */
    private function __construct()
    {
    }

    /**
     * Creates a clan object with the given data
     * @param array $data an associative array to fill up the members of the
     * clan class
     * @return Clan a clan object with the data given as it's members
     */
    public static function create(array $data): Clan
    {
        $clan = new Clan();
        parent::fill($data, $clan);
        if (is_array($clan->location)) {
            $clan->location = Location::create($clan->location);
        }
        return $clan;
    }
}
