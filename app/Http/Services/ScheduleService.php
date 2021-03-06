<?php

namespace App\Http\Services;

use App\Models\Data;
use Illuminate\Support\Facades\Storage;
use ZipArchive;

class ScheduleService
{
    /**
     * @return void
     */
    public function __invoke()
    {
        $savedPath = storage_path('app/public/RU.zip');
        copy('http://download.geonames.org/export/dump/RU.zip', $savedPath);
        $zip = new ZipArchive;
        if ($zip->open($savedPath)) {
            $zip->extractTo(Storage::path('/public/geonamesData'));
            $zip->close();
            unlink($savedPath);
        }

        $this->read();
    }

    /**
     * @return void
     */
    private function read()
    {
        $content = Storage::get('/public/geonamesData/RU.txt');
        $content = explode("\n", $content);
        array_pop($content);
        $arr = [];
        foreach ($content as $item) {
            $arr[] = explode("\t", $item);
        }

        $this->store($arr);
    }

    /**
     * @param array $data
     * @return void
     */
    public function store(array $data)
    {
        $arr = [];
        foreach ($data as $key => $datum) {
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

        $arr = array_chunk($arr, 3400);

        is_null(Data::first()) ?: Data::truncate();

        foreach ($arr as $item) {
            Data::insert($item);
        }
    }
}
