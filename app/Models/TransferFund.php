<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransferFund extends Model
{
    use HasFactory;

    protected $fillable = [
        'sender_account_id',
        'reciever_account_id',
        'sender_email',
        'reciever_email',
        'sender_full_name',
        'reciever_full_name',
        'sender_phone_no',
        'reciever_phone_no',
        'sender_wallet_id',
        'reciever_wallet_id',
        'transaction_type',
        'transaction_status',
        'amount'        
        
    ];
}
