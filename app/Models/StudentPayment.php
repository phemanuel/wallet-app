<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentPayment extends Model
{
    use HasFactory;

    protected $connection = 'mysql_second';
    protected $table = 'stdpayment';
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
        'percentstatus',
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
