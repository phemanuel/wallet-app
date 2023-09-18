<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class wallet_transaction extends Model
{
    protected $table = 'wallet_transactions';
    
    use HasFactory;

    protected $fillable = [
        'account_id',
        'wallet_id',
        'std_no',
        'full_name',
        'std_course',        
        'email',
        'phone_no',
        'amount',
        'amount_due',
        'transaction_id',
        'transaction_type',
        'transaction_status',
        'transaction_date',
        'response_code',
        'response_status',
        'flicks_transaction_id'
    ];
}
