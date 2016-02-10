<?php

namespace COCUrl;

/**
 * This is an enum/interface to hold the options for the location request of
 * which ranking to retrieve
 */
interface RankingId
{
    const CLANS   = 'clans';
    const PLAYERS = 'players';
    const NONE    = 'none';
}
