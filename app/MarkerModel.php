<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MarkerModel extends Model
{
    public $table='markers';
    protected $fillable=[
        'id',
        'authtoken',
        'marker',
        'linkpatt',
        'name',
        'tags',
        'description',
        'experienceid',
    ];
}
