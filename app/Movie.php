<?php

namespace ResoSystem;

use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    const PER_PAGE = 15;
    const PATH_MOVIES = '/images/movies/';
    public $timestamps = false;

    public $fillable = [
        'name', 'data_carrier', 'price'
    ];

    public function orders()
    {
        return $this->belongsToMany(Order::class);
    }

    public function insertDataToMoviesTable($name, $dataCarrier, $price)
    {
        Movie::create([
            'name' => $name,
            'data_carrier'=> $dataCarrier,
            'price' => $price
        ]);
    }
}
