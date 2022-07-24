<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Host extends Model
{
    use HasFactory;
    protected $table = 'hosts';
    public $timestamps = true;
    protected $fillable = [
        'user_id',
        'village_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
