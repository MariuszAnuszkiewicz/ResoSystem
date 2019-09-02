<?php

namespace ResoSystem;

use Illuminate\Database\Eloquent\Model;

class Music extends Model
{
    const PER_PAGE = 15;
    const PATH_MUSICS = '/images/musics/';
    public $timestamps = false;

    public $fillable = [
        'name', 'data_carrier', 'price'
    ];

    public function orders()
    {
        return $this->belongsToMany(Order::class);
    }

    public function insertDataToMusicsTable($name, $dataCarrier, $price)
    {
        Music::create([
            'name' => $name,
            'data_carrier'=> $dataCarrier,
            'price' => $price
        ]);
    }
}
