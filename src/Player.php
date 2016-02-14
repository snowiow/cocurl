<?php

namespace COCUrl;

final class Player extends COCEntity
{
    /**
     * The player name
     */
    public $name;

    /**
     * The experience level
     */
    public $expLevel;

    /**
     * The trophy count
     */
    public $trophies;

    /**
     * Count of won attacks
     */
    public $attackWins;

    /**
     * Count of won defenses
     */
    public $defenseWins;

    /**
     * Current ladder rank
     */
    public $rank;

    /**
     * Rank of the previous season
     */
    public $previousRank;

    /**
     * Clan of the player
     */
    public $clan;

    /**
     * The league of the player
     */
    public $league;

    /**
     * The role of a player inside a clan, if he has one
     */
    public $role;

    /**
     * The rank of the player inside a clan, if he has one
     */
    public $clanRank;

    /**
     * The rank of the player inside a clan, if he has one of the previous season
     */
    public $previousClanRank;

    /**
     * How many donations did the player do, if he has a clan
     */
    public $donations;

    /**
     * How many donations did the player received, if he has a clan
     */
    public $donationsReceived;

    /**
     * Private CTor. Clan Objects will be created via the create method
     */
    private function __construct()
    {
    }

    /**
     * Creates a player object with the given data
     * @param array $data an associative array to fill up the members of the
     * player class
     * @return Player a player object with the data given as it's members
     */
    public static function create(array $data): Player
    {
        $player = new Player();
        parent::fill($data, $player);
        if (is_array($player->clan)) {
            $player->clan = Clan::create($player->clan);
        }
        if (is_array($player->league)) {
            $player->league = League::create($player->league);
        }
        return $player;
    }
}
