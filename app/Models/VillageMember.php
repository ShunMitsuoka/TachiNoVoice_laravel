<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VillageMember extends Model
{
    use HasFactory;
    protected $table = 'village_members';
    public $timestamps = true;
    protected $fillable = [
        'user_id',
        'village_id',
        'role_id',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
