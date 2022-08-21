<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SatisfactionLevel extends Model
{
    use HasFactory;
    protected $table = 'satisfaction_levels';
    public $timestamps = true;
    protected $fillable = [
        'review_id',
        'policy_id',
        'satisfaction_level',
    ];
}
