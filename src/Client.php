<?php
/**
 * Client Class
 */
namespace COCUrl;

/**
 * The Client Class uses a CURL Client to realize the API Calls
 * @category COCUrl
 * @package COCUrl
 * @licence MIT
 */
class Client
{
    /**
     * COC API Base URL
     */
    const BASE_URL = 'https://api.clashofclans.com/v1/';

    /**
     * The URL to retrieve league information from the coc api
     */
    const LEAGUES_URL = 'leagues';

    /**
     * The URL to retrieve clans information from the coc api
     */
    const CLANS_URL = 'clans';

    /**
     * The URL to retrieve location information from the coc api
     */
    const LOCATIONS_URL = 'locations';

    /**
     * Access Token to get into the coc api
     */
    private $_accessToken;

    /**
     * The options used for the curl header
     */
    private $_curlHeader = [
        'Accept: application/json',
    ];

    /**
     * Client CTor.
     * @param string $accessToken A valid access token to access the Clash of
     * Clans API
     */
    public function __construct(string $accessToken)
    {
        $this->_accessToken  = $accessToken;
        $this->_curlHeader[] = 'Authorization: Bearer ' . $this->_accessToken;
    }

    /**
     * Retrieves the current access token
     * @return string the access token given on creation
     */
    public function getAccessToken()
    {
        return $this->_accessToken;
    }

    /**
     * Returns all the leagues available in Clash of Clans. Calls the API at
     * /leagues
     * @return array of leagues currently available in Clash of Clans
     */
    public function leagues(): array
    {
        $curlClient = curl_init(self::BASE_URL . self::LEAGUES_URL);
        curl_setopt($curlClient, CURLOPT_HTTPHEADER, $this->_curlHeader);
        curl_setopt($curlClient, CURLOPT_RETURNTRANSFER, true);
        $results = json_decode(curl_exec($curlClient), true);
        $leagues = [];
        foreach ($results['items'] as $result) {
            $leagues[] = League::create($result);
        }
        return $leagues;
    }

    /**
     * Returns all the locations available in Clash of Clans. Calls the API at
     * /locations
     * @param int              $id   a unique identifier for a location. If > 0,
     * then only the Location will be returned, otherwise all
     * @param string|RankingId $rank The kind of ranking you want to retrieve.
     * Clan based or Player based is supported.
     * @return array of locations currently available in Clash of Clans
     */
    public function locations(int $id = 0, $rank = RankingId::NONE)
    {
        if ($id && $rank !== RankingId::NONE) {
            return $this->_locationsByIdAndRank($id, $rank);
        }
        if ($id) {
            return $this->_locationsById($id);
        }
        $curlClient = curl_init(self::BASE_URL . self::LOCATIONS_URL);
        curl_setopt($curlClient, CURLOPT_HTTPHEADER, $this->_curlHeader);
        curl_setopt($curlClient, CURLOPT_RETURNTRANSFER, true);
        $results   = json_decode(curl_exec($curlClient), true);
        $locations = [];
        foreach ($results['items'] as $result) {
            $locations[] = Location::create($result);
        }
        return $locations;
    }

    /**
     * Search for clans by different approaches.
     * @param array|string $param if array it represents the possible filters,
     * which can be send to the coc api. If it is a string it represents the clan tag
     * which is send
     * @return array|Clan if searched with filters, it returns an array with clans,
     * who match the filter. If searched by tag, the Clan object is returned
     */
    public function clans($param, $members = false)
    {
        if (is_array($param)) {
            return $this->_clansByFilter($param);
        } else if ($members) {
            return $this->_clansMembersOnly($param);
        }
        return $this->_clanById($param);
    }

    /**
     * Search for clan members only of a specific clan
     * @param string $param the clan tag
     * @return array array of player who are members of the clan, hwich matches the
     * clan tag
     */
    private function _clansMembersOnly(string $param): array
    {
        $curlClient = curl_init(
            self::BASE_URL .
            self::CLANS_URL .
            '/' .
            \urlencode($param) .
            '/members'
        );
        curl_setopt($curlClient, CURLOPT_HTTPHEADER, $this->_curlHeader);
        curl_setopt($curlClient, CURLOPT_RETURNTRANSFER, true);
        $results = json_decode(curl_exec($curlClient), true);
        $members = [];
        foreach ($results['items'] as $result) {
            $members[] = Player::create($result);
        }
        return $members;
    }

    /**
     * Retrieves the clan, who matches the given id
     * @param string $param the clan tag
     * @return Clan a Clan object, containing the searched clan
     */
    private function _clanById(string $param): Clan
    {
        $curlClient = curl_init(
            self::BASE_URL .
            self::CLANS_URL .
            '/' .
            \urlencode($param)
        );
        curl_setopt($curlClient, CURLOPT_HTTPHEADER, $this->_curlHeader);
        curl_setopt($curlClient, CURLOPT_RETURNTRANSFER, true);
        $result = json_decode(curl_exec($curlClient), true);
        return Clan::create($result);
    }

    /**
     * Retrieves a list of clans, who matches a set of filters
     * @param array $params an array of filters. Keys are the names of filters, like
     * they are defined in the coc api, values are the filter values
     * @return array an array of clans who match the filters
     */
    private function _clansByFilter(array $params): array
    {
        $url = self::BASE_URL . self::CLANS_URL . '?';
        $url .= http_build_query($params);
        $curlClient = curl_init($url);
        curl_setopt($curlClient, CURLOPT_HTTPHEADER, $this->_curlHeader);
        curl_setopt($curlClient, CURLOPT_RETURNTRANSFER, true);
        $results = json_decode(curl_exec($curlClient), true);
        $clans   = [];
        foreach ($results['items'] as $result) {
            $clans[] = Clan::create($result);
        }

        return $clans;
    }

    /**
     * Returns a location with the given id
     * @param int $id the unique identifier of the location
     * @return The Location with the given id
     */
    private function _locationsById(int $id): Location
    {
        $curlClient = curl_init(self::BASE_URL . self::LOCATIONS_URL . '/' . $id);
        curl_setopt($curlClient, CURLOPT_HTTPHEADER, $this->_curlHeader);
        curl_setopt($curlClient, CURLOPT_RETURNTRANSFER, true);
        $result = json_decode(curl_exec($curlClient), true);
        return Location::create($result);
    }

    /**
     * Based on a Location, retrieve the local rankings
     * @param int              $id   the unique identifier of the location
     * @param string|RankingId $rank the kind of ranking you want to retrieve.
     * Based on Clans and based on players is supported at the moment.
     * @return The clans/player who are located at the location id
     */
    private function _locationsByIdAndRank(int $id, $rank)
    {
        $curlClient = curl_init(
            self::BASE_URL .
            self::LOCATIONS_URL .
            '/' .
            $id .
            '/rankings/' .
            $rank
        );
        curl_setopt($curlClient, CURLOPT_HTTPHEADER, $this->_curlHeader);
        curl_setopt($curlClient, CURLOPT_RETURNTRANSFER, true);
        $results = json_decode(curl_exec($curlClient), true);
        $items   = [];
        foreach ($results['items'] as $result) {
            if ($rank === RankingId::CLANS) {
                $items[] = Clan::create($result);
            } else {
                $items[] = Player::create($result);
            }
        }
        return $items;
    }
}
