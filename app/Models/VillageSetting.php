<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VillageSetting extends Model
{
    use HasFactory;
    protected $table = 'village_settings';
    public $timestamps = true;
    protected $fillable = [
        'village_id',
        'core_member_limit',
    ];
}
