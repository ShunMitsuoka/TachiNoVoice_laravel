<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MPhasesStatus extends Model
{
    use HasFactory;
    protected $table = 'm_phases_statuses';
    public $timestamps = false;
    protected $fillable = [
        'status_name',
        'deleted_flg',
    ];
}
