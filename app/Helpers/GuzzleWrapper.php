<?php

namespace App\Helpers;

use App\Helpers\Exceptions\BackendException;
use GuzzleHttp\Client;

/**
 * Class GuzzleWrapper
 * @package App\Backend
 */
class GuzzleWrapper
{
    /**
     * @param $baseUri
     * @param $endpoint
     * @param array $parameters
     * @param array $headers
     * @return mixed
     * @throws BackendException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public static function get($baseUri, $endpoint, $parameters = [], $headers = [])
    {
        try {
            $client = new Client(['base_uri' => $baseUri]);
            $response = $client->request('GET', $endpoint, [
                'query' => $parameters,
                'headers' => $headers
            ]);
            $responseData = json_decode($response->getBody()->getContents(), true);
            return $responseData;
        } catch (\Exception $e) {
            throw new \App\Helpers\BackendException(
                'Unable get data from service endpoint:' . $endpoint . ' : ' . $e->getMessage()
            );
        }
    }
}
