<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Phase extends Model
{
    use HasFactory;
    protected $table = 'phases';
    public $timestamps = true;
    protected $fillable = [
        'village_id',
        'm_phase_id',
        'm_phase_status_id',
    ];
}
