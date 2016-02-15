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
     * Type of the Clan (Open, inviteOnly etc.)
     */
    public $type;

    /**
     * The clans description
     */
    public $description;

    /**
     * Location object, which holds the location information about this clan
     */
    public $location;

    /**
     * Array of links wiht different sizes of the clan badge image
     */
    public $badgeURLs;

    /**
     * The war frequency of the clan
     */
    public $warFrequency;

    /**
     * The level of the Clan
     */
    public $clanLevel;

    /**
     * Count of wars the clan won
     */
    public $warWins;

    /**
     * How many members are currently in the clan
     */
    public $members;

    /**
     * How many trophies are required to join the clan
     */
    public $requiredTrophies;

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

    /*+
     * Array of Members who are part of the clan
     */
    public $memberList;

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
        if (is_array($clan->memberList)) {
            $members = [];
            foreach ($clan->memberList as $member) {
                $members[] = Player::create($member);
            }
            $clan->memberList = $members;
        }
        return $clan;
    }
}
