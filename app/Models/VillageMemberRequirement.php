<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VillageMemberRequirement extends Model
{
    use HasFactory;
    protected $table = 'village_member_requirements';
    public $timestamps = true;
    protected $fillable = [
        'village_id',
        'requirement',
    ];
}
