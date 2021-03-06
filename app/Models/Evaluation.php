<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evaluation extends Model
{
    use HasFactory;
    protected $table = 'evaluations';
    public $timestamps = true;
    protected $fillable = [
        'opinion_id',
        'user_id',
        'evaluation',
        'created_at',
        'deleted_flg',
    ];
}
