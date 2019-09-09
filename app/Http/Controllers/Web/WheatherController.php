<?php

namespace App\Http\Controllers\Web;

use App\Api\YandexApi;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

class WheatherController extends Controller
{



    public function index()
    {
        $seconds = 3600;
        try {
            $wheather = Cache::remember('users', $seconds, function () {
                $lat = 53.243562;
                $lon = 34.363407;
                $yandex = new YandexApi();
                return $yandex->getWheather($lat, $lon);
            });
        } catch (GuzzleException $e) {
            $wheather['error'] = 'Упс, сейчас погода пока не доступна!';
        }
        return view('web.index', compact('wheather'));
    }
}
