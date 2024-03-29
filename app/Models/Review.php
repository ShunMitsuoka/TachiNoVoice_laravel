<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;
    protected $table = 'reviews';
    public $timestamps = true;
    protected $fillable = [
        'user_id',
        'village_id',
        'comment',
        'comment_public_flg'
    ];
}
