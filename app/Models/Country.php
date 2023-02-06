<?php

namespace App\Models;

use App\Base\Slug\HasSlug;
use App\Models\Traits\HasActive;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Nicolaslopezj\Searchable\SearchableTrait;

class Country extends Model
{
    use SearchableTrait, 
    HasActive;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'countries';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'dial_code',
        'code',
        'active',
        'flag',
        'currency_name',
        'currency_code',
        'currency_symbol'
    ];

    /**
     * The attributes that can be used for sorting with query string filtering.
     *
     * @var array
     */
    public $sortable = [
        'name',
    ];

    /**
    * Get the Flag's full file path.
    *
    * @param string $value
    * @return string
    */
    public function getFlagAttribute($value)
    {
       if (empty($value)) {
            return null;
        }
        return Storage::disk('public')->url(file_path($this->uploadPath(), $value));
    }

    /**
     * The default file upload path.
     *
     * @return string|null
     */
    public function uploadPath()
    {
        return config('base.country.upload.flag.path');
    }

    /**
     * Get all the countries from the JSON file.
     *
     * @return array
     */
    public static function allJSON()
    {
        $route = dirname(dirname(__FILE__)) . '/Helpers/Countries/countries.json';
        return json_decode(file_get_contents($route), true);
    }

    public function countryDetail()
    {
        return $this->belongsTo(Country::class, 'name', 'currency_code' , 'currency_symbol', 'flag');
    }

    protected $searchable = [
        'columns' => [
            'countries.name' => 20,
            'countries.currency_code'=> 20
        ],
    ];
}

