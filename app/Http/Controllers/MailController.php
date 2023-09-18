<?php

namespace App\Http\Controllers;
use App\Mail\MyCustomEmail;
use App\Mail\PaymentEmail;
use App\Mail\FundTransferRecieverEmail;
use App\Mail\FundTransferSenderEmail;
use App\Mail\PayWalletEmail;
use Illuminate\Http\Request;
use PDF;
//use Mail;
use App\Models\wallet_transaction;
use Illuminate\Support\Facades\Mail;


class MailController extends Controller
{
    //
    public function index()
    {
        try {
            // Retrieve email address from the session
            $email_address = session('email');
            $full_name = session('full_name');

            $data['email'] = $email_address;
            $data['full_name'] = "Dear " . $full_name . ",";
            $data['title'] = 'OYSCHST WALLET';

            // Load the PDF
            $pdf = PDF::loadview('emails.sendmail', $data);

            $data['pdf'] = $pdf;

            // Send the email
            Mail::to($data['email'])->send(new MyCustomEmail($data));

            // Success: Email sent
            session()->flash('success', 'Account setup successful! You can login.');

            return redirect('login');
        } catch (\Exception $e) {
            // Error handling: Handle the error and display an error message
            session()->flash('error', 'An error occurred while sending the email.');

            return redirect('login');
        }
    }

    public function mailSuccess($transaction_id)
    {   
        try {
            $transaction = wallet_transaction::where('transaction_id', $transaction_id)->first();       
            //-------------
            $data = [
                'email' => $transaction->email,
                'full_name' => $transaction->full_name,
                'transaction_id' => $transaction->transaction_id,
                'wallet_id' => $transaction->wallet_id,
                'amount' => $transaction->amount,
                'amount_due' => $transaction->amount_due,
                'transaction_status' => $transaction->transaction_status,
                'response_code' => $transaction->response_code,
                'response_status' => $transaction->response_status,
                'title' => 'OYSCHST WALLET',
                'transaction_message' => 'Your transaction was successful',
                'flicks_transaction_id' => $transaction->flicks_transaction_id,
            ];

            // $data['email'] = $email_address;
            // $data['full_name'] = "Dear ". $full_name . ",";
            // $data['title'] ='OYSCHST WALLET';
            // $data['body'] ='Account has been created successfully';

            $pdf = PDF::loadview('emails.payment-mail',$data);

            $data['pdf'] = $pdf;
            Mail::to($data['email'])->send(new PaymentEmail($data));

            //dd('Email sent');
            session()->flash('success', 'Your transaction was successful, payment details has been sent to your email.');
            
            return redirect('dashboard');
        } catch (\Exception $e) {
        // Error handling: Handle the error and display an error message
        session()->flash('error', 'An error occurred while sending the email.');

        return redirect('dashboard');
         }
    }

    public function mailFailed($transaction_id)
    {   
        try {
        $transaction = wallet_transaction::where('transaction_id', $transaction_id)->first();       
        //-------------
        $data = [
            'email' => $transaction->email,
            'full_name' => $transaction->full_name,
            'transaction_id' => $transaction->transaction_id,
            'wallet_id' => $transaction->wallet_id,
            'amount' => $transaction->amount,
            'amount_due' => $transaction->amount_due,
            'transaction_status' => $transaction->transaction_status,
            'response_code' => $transaction->response_code,
            'response_status' => $transaction->response_status,
            'title' => 'OYSCHST WALLET',
            'transaction_message' => 'Your transaction was not successful',
            'flicks_transaction_id' => $transaction->flicks_transaction_id,
        ];
        $pdf = PDF::loadview('emails.payment-mail',$data);

        $data['pdf'] = $pdf;
        Mail::to($data['email'])->send(new PaymentEmail($data));

        //dd('Email sent');
        session()->flash('error', 'Your transaction was not successful, payment details has been sent to your email.');
        
        return redirect('dashboard');
        } catch (\Exception $e) {
        // Error handling: Handle the error and display an error message
        session()->flash('error', 'An error occurred while sending the email.');

        return redirect('dashboard');
        }
    }

    public function mailFundTransfer(Request $request)
    {   
        try {
        $senderWalletId = $request->sender_wallet_id;
        $recieverWalletId = $request->reciever_wallet_id;
        $amount = $request->amount;
        $senderWalletBalance = $request->sender_wallet_balance;
        $recieverWalletBalance = $request->reciever_wallet_balance;
        $senderEmail = $request->sender_email;
        $recieverEmail = $request->reciever_email;
        $senderFullName = $request->sender_full_name;
        $recieverFullName = $request->reciever_full_name;
        //-------------
        $data = [            
            'title' => 'OYSCHST WALLET',
            'transaction_message_sender' => 'Fund transfer was successful',
            'transaction_message_reciever' => 'Wallet has been credited successfully',
            'transaction_date' => date('Y-m-d H:i:s'),
            'sender_wallet_id' => $senderWalletId,
            'sender_wallet_balance' => $senderWalletBalance,
            'reciever_wallet_id' => $recieverWalletId,
            'reciever_wallet_balance' => $recieverWalletBalance,   
            'amount' => $amount,
            'sender_email' => $senderEmail,
            'reciever_email' => $recieverEmail,
            'sender_full_name' => $senderFullName,
            'reciever_full_name' => $recieverFullName,
        ];

        $pdf = PDF::loadview('emails.fund-transfer-sender-mail',$data);

        $data['pdf'] = $pdf;     

        // Send email to the sender
        Mail::to($data['sender_email'])->send(new FundTransferSenderEmail($data));

        // Send email to the receiver
        Mail::to($data['reciever_email'])->send(new FundTransferRecieverEmail($data));

        //dd('Email sent');
        session()->flash('success', 'Fund transfer was successful, details has been sent to your email.');
        
        return redirect('dashboard');
        } catch (\Exception $e) {
        // Error handling: Handle the error and display an error message
        session()->flash('error', 'An error occurred while sending the email.');

        return redirect('dashboard');
        }
    }

    public function mailPayWallet(Request $request)
    {   
        try {   
        // Retrieve the data from the query parameters
        $walletdata = $request->all();

        // Access the data stored in the $walletdata array
        $full_name = $walletdata['full_name'];
        $wallet_id = $walletdata['wallet_id'];
        $amount = $walletdata['amount'];
        $wallet_balance = $walletdata['wallet_balance'];
        $transaction_type = $walletdata['transaction_type'];
        $email = $walletdata['email'];
        //-------------
        $data = [            
            'title' => 'OYSCHST WALLET',
            'transaction_message' => 'Your payment was successful',
            'transaction_date' => date('Y-m-d H:i:s'),
            'wallet_id' => $wallet_id,
            'wallet_balance' => $wallet_balance, 
            'amount' => $amount,
            'email' => $email,
            'full_name' => $full_name,
            'transaction_type' => $transaction_type,        
        ];
      

        $pdf = PDF::loadview('emails.pay-wallet-mail',$data);

        $data['pdf'] = $pdf;
        Mail::to($data['email'])->send(new PayWalletEmail($data));

        //dd('Email sent');
        session()->flash('success', 'Payment was successful, details has been sent to your email.');
        
        return redirect('dashboard');
        } catch (\Exception $e) {
        // Error handling: Handle the error and display an error message
        session()->flash('error', 'An error occurred while sending the email.');

        return redirect('dashboard');
        }
    }
}
