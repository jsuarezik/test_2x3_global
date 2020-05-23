<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Client extends Model
{
    protected $table = 'client';

    protected $fillable = [
        'email'
    ];

    //Relations 
    public function payments() {
        return $this->hasMany(Payment::class, 'user_id');
    }
    //Accesors
    function getJoinDateAttribute() {
        return Carbon::parse($this->attributes['join_date'], 'America/Lima')->toDateString();
    }

    //Functions
    public static function rules() {
        return [
            'create' => [
                'email' => 'required|unique:client,email',
                'join_date' => 'sometimes|nullable|date'
            ]
        ];
    }
}