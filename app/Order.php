<?php

namespace ResoSystem;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Order extends Model
{
    const STATUS_REALIZATION_TO_COMPILE = 1;
    const STATUS_REALIZATION_DELIVERY = 2;
    const STATUS_REALIZATION_TO_DELIVER = 3;

    public $timestamps = true;

    public $fillable = [
        'client_id', 'date_order', 'date_of_realization', 'status', 'comments_to_order', 'created_at', 'updated_at'
    ];

    protected $dates = [
        'created_at',
        'updated_at'
    ];

    public function getCreatedAtAttribute()
    {
        return $this->dates['created_at'] = Carbon::now("Europe/Warsaw");
    }

    public function getUpdatedAtAttribute()
    {
        return $this->dates['updated_at'] = Carbon::now("Europe/Warsaw");
    }
}
