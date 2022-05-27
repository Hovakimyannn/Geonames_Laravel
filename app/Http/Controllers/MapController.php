<?php

namespace App\Http\Controllers;

use App\Models\Data;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Storage;

class MapController extends Controller
{
    public function read()
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
        $this->store($arr);
    }

    public function store(array $data)
    {
        $start = microtime(true);
        $arr = [];
        foreach ($data as $key=>$datum) {
            $arr[$key]['geoname_id'] = $datum[0];
            $arr[$key]['name'] = $datum[1];
            $arr[$key]['asciiname'] = $datum[2];
            $arr[$key]['alternatenames'] = $datum[3];
            $arr[$key]['latitude'] = $datum[4];
            $arr[$key]['longitude'] = $datum[5];
            $arr[$key]['feature_class'] = $datum[6];
            $arr[$key]['feature_code'] = $datum[7];
            $arr[$key]['country_code'] = $datum[8];
            $arr[$key]['cc2'] = $datum[9];
            $arr[$key]['admin1_code'] = $datum[10];
            $arr[$key]['admin2_code'] = $datum[11];
            $arr[$key]['admin3_code'] = $datum[12];
            $arr[$key]['admin4_code'] = $datum[13];
            $arr[$key]['population'] = $datum[14];
            $arr[$key]['elevation'] = $datum[15];
            $arr[$key]['dem'] = $datum[16];
            $arr[$key]['timezone'] = $datum[17];
            $arr[$key]['modification_date'] = $datum[18];
        }
        $arr = array_chunk($arr,3400);
        foreach ($arr as $item) {
            Data::insert($item);
        }
        $time_elapsed_secs = microtime(true) - $start;
        echo $time_elapsed_secs;
    }
}
