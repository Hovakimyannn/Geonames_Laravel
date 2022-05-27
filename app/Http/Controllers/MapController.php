<?php

namespace App\Http\Controllers;

use App\Models\Data;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Storage;

class MapController extends Controller
{
    public function grisha()
    {
        $content = Storage::get('RU.txt');
        $content = explode("\n", $content);
        array_pop($content);

        $arr = [];
        foreach ($content as $item) {
            $arr[] = explode("\t", $item);
        }

        $data = new Data();

       /* if (!$data->exists()) {
            foreach ($arr as $item) {
                $data->create([
                    'geoname_id' => $item[0],
                    'name' => $item[1],
                    'asciiname' => $item[2],
                    'alternatenames' => $item[3],
                    'latitude' => $item[4],
                    'longitude' => $item[5],
                    'feature_class' => $item[6],
                    'feature_code' => $item[7],
                    'country_code' => $item[8],
                    'cc2' => $item[9],
                    'admin1_code' => $item[10],
                    'admin2_code' => $item[11],
                    'admin3_code' => $item[12],
                    'admin4_code' => $item[13],
                    'population' => $item[14],
                    'elevation' => $item[15],
                    'dem' => $item[16],
                    'timezone' => $item[17],
                    'modification_date' => $item[18],
                ]);
            }
        }*/

        /*Redis::pipeline(function ($pipe) {
            for ($i = 0; $i < 1000; $i++) {
                $pipe->set("key:$i", $i);
            }
        });*/
        //Redis::flushAll();
        foreach ($arr as $item) {
            Redis::hSet($item[0],
                "geoname_id", $item[0],
                'name', $item[1],
                'asciiname', $item[2],
                'alternatenames', $item[3],
                'latitude', $item[4],
                'longitude', $item[5],
                'feature_class', $item[6],
                'feature_code', $item[7],
                'country_code', $item[8],
                'cc2', $item[9],
                'admin1_code', $item[10],
                'admin2_code', $item[11],
                'admin3_code', $item[12],
                'admin4_code', $item[13],
                'population', $item[14],
                'elevation', $item[15],
                'dem', $item[16],
                'timezone', $item[17],
                'modification_date', $item[18]);
        }

        /*Redis::hSet('h', 'key1', 'hello', 'key2', 'hello2');
        $value = Redis::hGet('h', 'key2');*/

        /*dd($value);*/

        dd('9');

        echo "<pre>";
        print_r($arr);
        dd();

    }

    public function getAllFromRedis()
    {
        $keys = Redis::keys('*');
        $dbdata = Data::all();
        dd($keys[360000]);
        dd(Redis::hGetAll('Yeskino'));
    }
}
