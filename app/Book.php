<?php

namespace ResoSystem;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    const PER_PAGE = 15;
    const PATH_COMPUTER_SCIENCE = '/images/books/computer_science/';
    const PATH_GEOPOLITICS = '/images/books/geopolitics/';
    const PATH_LITERATURE = '/images/books/literature/';
    public $timestamps = false;

    public $fillable = [
       'name', 'isbn_number', 'price'
    ];

    public function orders()
    {
        return $this->belongsToMany(Order::class);
    }

    public function insertDataToBooksTable($name, $isbnNumber, $price)
    {
        Book::create([
            'name' => $name,
            'isbn_number'=> $isbnNumber,
            'price' => $price
        ]);
    }
}
