<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhaseSetting extends Model
{
    use HasFactory;
    protected $table = 'phase_settings';
    public $timestamps = true;
    protected $fillable = [
        'phase_id',
        'end_flg',
        'by_manual_flg',
        'by_limit_flg',
        'by_date_flg',
        'border_date',
    ];
}
