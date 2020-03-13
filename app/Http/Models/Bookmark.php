<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Bookmark extends Model
{
    protected $fillable = ['title', 'url', 'favicon', 'description', 'keywords'];
}
