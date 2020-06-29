<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExperienceModel extends Model
{
    public $table='experiences';
    protected $fillable = [
        'id',
        'authtoken',
        'experience',
        'share_experience',
        'thumbnail',
        'name',
        'tags',
        'description'
    ];

}
