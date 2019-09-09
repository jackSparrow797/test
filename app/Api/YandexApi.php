<?php
/**
 * Created by PhpStorm.
 * User: Таня
 * Date: 09.09.2019
 * Time: 13:10
 */

namespace App\Api;


class YandexApi
{
    const API_KEY = '482773e4-0b66-45ba-ae8c-cd1277badddc';

    private $coords = [];

    public function getWheather($lat, $lon)
    {
        $headers = [
            'headers' => [
                'X-Yandex-API-Key' => self::API_KEY
            ]
        ];
        $this->setCoords($lat, $lon);
        $client = new \GuzzleHttp\Client($headers);
        $params = $this->prepareParams($this->coords);
        $url = 'https://api.weather.yandex.ru/v1/informers?' . $params;
        $response = $client->request('GET', $url);
        $content = $response->getBody()
            ->getContents();
        $out = json_decode($content, true);
        return $out;
    }

    /**
     * @param array $array
     * @return string
     */
    private function prepareParams(array $array)
    {
        return http_build_query($array);
    }


    /**
     * @param $lat
     * @param $lon
     */
    private function setCoords($lat, $lon)
    {
        $this->coords = [
            'lat' => $lat,
            'lon' => $lon
        ];
    }
}