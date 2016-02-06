<?php

namespace COCUrl;

/**
 * The COC API Location
 */
class Location extends COCEntity
{
    /**
     * Unique identifier used by SuperCell
     */
    public $id;

    /**
     *  Name of the Location
     */
    public $name;

    /**
     * Is the location a country or not
     */
    public $isCountry;

    /**
     * The countryCode of the country. Only set if isCountry is true
     */
    public $countryCode;

    /**
     * Private CTor. League Objects will be created via the create method
     */
    private function __construct()
    {
    }

    /**
     * Creates a location object with the given data
     * @param array $data an associative array to fill up the members of the
     * location class
     * @return Location a location object with the data given as it's members
     */
    public static function create(array $data): Location
    {
        $location = new Location();
        parent::fill($data, $location);
        return $location;
    }
}
