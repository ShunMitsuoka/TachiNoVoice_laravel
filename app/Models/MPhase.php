<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MPhase extends Model
{
    use HasFactory;
    protected $table = 'm_phases';
    public $timestamps = false;
    protected $fillable = [
        'phase_name',
        'deleted_flg',
    ];
}
