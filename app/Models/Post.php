<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'file_path', 'caption', 'fite_type'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
