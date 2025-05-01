<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use SoftDeletes;

    protected $fillable = ['user_id', 'media', 'caption', 'file_type', 'is_archived'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
