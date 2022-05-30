<?php

namespace App\Http\Controllers;

use App\Models\Data;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use ZipArchive;

class MapController extends Controller
{

    /**
     * @return void
     */
    public function read()
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


    public function findTwelveNeighboringCountries(Request $request)
    {
        $givenCountry = Data::find($request->id);
        $givenCountryLatitude = deg2rad($givenCountry->latitude);
        $givenCountryLongitude = deg2rad($givenCountry->longitude);

        $earth_radius = 6371;

        $datas = Data::all(['geoname_id', 'latitude', 'longitude']);
        $CountriesDatas = [];

        foreach ($datas as $data) {
            $latitude = deg2rad($data->latitude);
            $longitude = deg2rad($data->longitude);

            $deltaLatitude = $givenCountryLatitude - $latitude;
            $deltaLongitude = $givenCountryLongitude - $longitude;

            $angle = 2 * asin(sqrt(pow(sin($deltaLatitude / 2), 2) +
                    cos($givenCountryLatitude) * cos($latitude) * pow(sin($deltaLongitude / 2), 2)));

            $distance = round($angle * $earth_radius, 2);

            $CountriesDatas[] = [
                'distance' => $distance,
                'country_id' => $data->geoname_id
            ];
        }

        asort($CountriesDatas);
        $twelveNeighboringCountries = array_slice($CountriesDatas, 1, 20);

        $country_ids = [];
        foreach ($twelveNeighboringCountries as $item) {
            $country_ids[] = $item['country_id'];
        }

        $countries = Data::whereIn('geoname_id', $country_ids)->pluck('name');

        return new JsonResponse([
            $countries,
            200
        ]);
    }

    /**
     * @return void
     */
    public function downloadZip()
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
}
