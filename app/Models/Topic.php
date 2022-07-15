<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    use HasFactory;
    protected $table = 'topics';
    public $timestamps = true;
    protected $fillable = [
        'village_id',
        'title',
        'content',
        'note',
        'deleted_flg',
    ];
}
