<?php

namespace ResoSystem;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    const ADD_ORDER = 'ADD_ORDER';
    const MANAGE_ORDER = 'MANAGE_ORDER';

    public $timestamps = false;

    public $fillable = [
       'user_id', 'client_priviliges'
    ];

    public function insertToClientTable($userId, $clientPriviliges)
    {
        Client::create([
            'user_id' => $userId,
            'client_priviliges' => $clientPriviliges
        ]);
    }
}
