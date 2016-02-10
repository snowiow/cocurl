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
     * @param int $id a unique identifier for a location. If > 0, then only the
     * Location will be returned, otherwise all
     * @return array of locations currently available in Clash of Clans
     */
    public function locations(int $id = 0)
    {
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

    public function clans(array $params)
    {
        $url = self::BASE_URL . self::CLANS_URL;
        $url .= http_build_query($params);
        return $url;
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
}
