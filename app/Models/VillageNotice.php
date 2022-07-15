<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VillageNotice extends Model
{
    use HasFactory;
    protected $table = 'village_notices';
    public $timestamps = true;
    protected $fillable = [
        'type',
        'village_id',
        'content',
    ];
}
