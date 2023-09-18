<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeptPayment extends Model
{
    use HasFactory;

    protected $connection = 'mysql_second';
    protected $table = 'deptpayment';
    public $timestamps = false;
    
    protected $fillable = [
        'state',
        'gender',
        'fullname',
        'matricno',
        'emailaddy',
        'mobileno',
        'feeamount',
        'balance',
        'course',
        'level',
        'feetype',
        'bankname',
        'tellerno',
        'session1',
        'paymentdate',
        'paymentdate1',
        'picturename',
        'date1',
        'confirmby',
        'transno',
        'paymode'
    ];
}
