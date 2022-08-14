<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Opinion extends Model
{
    use HasFactory;
    protected $table = 'opinions';
    public $timestamps = true;
    protected $fillable = [
        'village_id',
        'user_id',
        'category_id',
        'opinion',
        'deleted_flg',
    ];

    public function scopeNotDeleted($query)
    {
        return $query->where('opinions.deleted_flg', false);
    }
}
