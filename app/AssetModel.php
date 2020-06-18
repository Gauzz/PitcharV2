<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AssetModel extends Model
{
    public $table='assets';
    protected $fillable = [
        'authtoken',
        'type',
        'objthumbnail',
        'obj',
        'mtl',
        'gltf',
        'fbx',
        'image',
        'name',
        'tags',
    ];
}
