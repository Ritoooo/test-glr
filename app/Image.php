<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $table = 'migrations_file';
    protected $fillable = ['name_image', 'date_created'];
    public $timestamps = false;
}
