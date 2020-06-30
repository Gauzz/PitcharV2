<?php

namespace App;

use GuzzleHttp\Psr7\Request;
use Illuminate\Database\Eloquent\Model;

class MediaModel extends Model
{
    public $table = 'media';
    
    protected $fillable = [
        'authtoken',
        'type',
        'video',
        'thumbnail',
        'audio',
        'name',
        'tags',
        'extension'
    ];
}
