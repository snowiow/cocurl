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
