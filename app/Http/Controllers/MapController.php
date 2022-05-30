<?php

namespace App\Http\Controllers;

use App\Models\Data;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MapController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
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
}
