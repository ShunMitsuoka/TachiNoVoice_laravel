<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MemberConfirmVillageNotice extends Model
{
    use HasFactory;
    protected $table = 'member_confirm_village_notices';
    public $timestamps = false;
    protected $fillable = [
        'village_id',
        'user_id',
    ];
}
