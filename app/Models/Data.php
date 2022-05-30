<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Data
 *
 * @property int $geoname_id
 * @property string $name
 * @property string $asciiname
 * @property string $alternatenames
 * @property string $latitude
 * @property string $longitude
 * @property string $feature_class
 * @property string $feature_code
 * @property string $country_code
 * @property string $cc2
 * @property string $admin1_code
 * @property string $admin2_code
 * @property string $admin3_code
 * @property string $admin4_code
 * @property int $population
 * @property string $elevation
 * @property int $dem
 * @property string $timezone
 * @property string $modification_date
 * @method static \Illuminate\Database\Eloquent\Builder|Data newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Data newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Data query()
 * @method static \Illuminate\Database\Eloquent\Builder|Data whereAdmin1Code($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Data whereAdmin2Code($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Data whereAdmin3Code($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Data whereAdmin4Code($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Data whereAlternatenames($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Data whereAsciiname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Data whereCc2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Data whereCountryCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Data whereDem($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Data whereElevation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Data whereFeatureClass($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Data whereFeatureCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Data whereGeonameId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Data whereLatitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Data whereLongitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Data whereModificationDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Data whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Data wherePopulation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Data whereTimezone($value)
 * @mixin \Eloquent
 */
class Data extends Model
{
    use HasFactory;


    public $timestamps = false;
    protected $primaryKey = 'geoname_id';

}
