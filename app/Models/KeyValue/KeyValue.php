<?php

namespace App\Models\KeyValue;


use Illuminate\Database\Eloquent\Model;

class KeyValue extends Model
{
    protected $table = 'key_values';

    protected $fillable = ['key', 'value','type','created_at','updated_at'];
    public $timestamps = true;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
    }
}
