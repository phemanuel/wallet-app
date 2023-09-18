<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentPaymentAcct extends Model
{
    use HasFactory;

    protected $connection = 'mysql_second';
    protected $table = 'stdpaymentacct';
    public $timestamps = false;
    
    protected $fillable = [
        'state',
        'gender',
        'fullname',
        'matricno',
        'emailaddy',
        'mobileno',
        'amounttopay',
        'amountpaid',
        'balance',
        'course',
        'academiclevel',
        'paymentlevel',
        'feestatus',
        'session1',
        'confirmby',
        'tutionfee',
        'otherfee',
        'deptfee',
        'totalfee',
        'percentstatus',
        'percentvalue',

    ];
}
