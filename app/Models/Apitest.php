<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class apitest extends Model
{
    protected $table = 'apitest';

    use HasFactory;

    protected $fillable = [
        'std_no',
        'std_name',
        'std_course'
    ];
}
