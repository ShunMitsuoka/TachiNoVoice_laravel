<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PublicInformation extends Model
{
    use HasFactory;
    protected $table = 'public_informations';
    public $timestamps = true;
    protected $fillable = [
        'village_id',
        'nickname',
        'gender_id',
        'age_id',
    ];
}
