<?php

namespace App\Models\Admin;

use App\Models\Traits\HasActive;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Admin\ZoneSurgePrice;

class ZoneSurgeDay extends Model
{
    use HasActive;
    
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'zone_surge_days';

    protected $fillable = [
        'zone_surge_price_id','week_day'
    ];


    public function zoneSurgePrice()
    {
        return $this->belongsTo(ZoneSurgePrice::class, 'zone_surge_price_id', 'id');
    } 

}
