<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Payment extends Model
{
    protected $table = 'payment';

    protected $fillable = ['payment_date', 'expires_at', 'status', 'user_id', 'clp_usd'];

    protected $primaryKey = 'uuid';

    public $incrementing = false;

    //Relations
    public function client() {
        return $this->belongsTo(Client::class, 'user_id');
    }
    //Accesors

    //Mutators
    function setUuidAttribute($value = null) {
        $this->attributes['uuid'] = Str::uuid();
    }   
    //Functions
    public static function rules() {
        return [
            'create' => [
                'payment_date' => 'sometimes|nullable|date', 
                'expires_at' => 'required|date', 
                'status' => 'required|in:pending,paid', 
                'user_id' => 'required|exists:client,id'
            ]
        ];
    }
    //Scopes
    function scopeOfClient($query, $clientId = null ) {
        return !$clientId ? $query : $query->where('user_id', $clientId);
    }

    function scopeOfDate($query, $date = null) {
        return !$date ? $query : $query->whereDate('payment_date', $date);
    }

    function scopeOfNotNullKey($query, $key) {
        return $query->whereNotNull($key);
    }
}
