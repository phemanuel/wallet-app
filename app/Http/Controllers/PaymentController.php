<?php

namespace App\Http\Controllers;

use App\Models\DeptPayment;
use App\Models\DeptPaymentAcct;
use App\Models\TransferFund;
use App\Models\wallet_transaction;
use App\Models\StudentAcceptance;
use App\Models\StudentPayment;
use App\Models\StudentPaymentAcct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;



class PaymentController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }    
        
    
    //---load wallet
    public function index()
    {   
        $yearkeep = date('Y');
        $monthkeep = date('m');
        $daykeep = date('d');
        $transaction_id = "WA" . $yearkeep.$monthkeep.$daykeep . substr(uniqid(), 7, 5);
        return view('payment.load-wallet', compact('transaction_id'));
    }

    //--Save transaction to database and go to the payment page 
    public function loadPaymentSave(Request $request)
    {
        //dd('Reached here')
        //---create new transaction
        wallet_transaction::create([

            'account_id' => $request->account_id,
            'wallet_id' => $request->wallet_id,
            'std_no' => $request->std_no,            
            'full_name' => $request->full_name,
            'email' => $request->email,
            'phone_no' => $request->phone_no,
            'std_course' => $request->std_course,
            'amount' => $request->amount,
            'amount_due' => $request->amount + 350,
            'transaction_id' => $request->transaction_id,
            'transaction_type' => $request->transaction_type,
            'transaction_status' => 'Pending',
            'transaction_date' => date('Y-m-d H:i:s'),
            'response_code' => '',
            'response_status' => '',
            'flicks_transaction_id' => ''            

        ]);

        session([
            'account_id' => $request->input('account_id'),
            'wallet_id' => $request->input('wallet_id'),
            'std_no' => $request->input('std_no'),
            'full_name' => $request->input('full_name'),
            'email' => $request->input('email'),
            'phone_no' => $request->input('phone_no'),
            'std_course' => $request->input('std_course'),
            'amount' => $request->input('amount'),
            'amount_due' => $request->input('amount') + 350,
            'transaction_id' => $request->input('transaction_id'),
        ]);

        return redirect()->route('load-wallet-payment-page');
    }

    public function loadPaymentPage()
    {   
        $merchant_id = "FLKOYSCHST001";
        $product_id = "FLKISWCP001";
        $product_description = "Fund Wallet";
        $amounttopay = session('amount');  // Get the amount to pay from your logic
        $total_amount_due = ($amounttopay + 350) * 100;
        $currency = "566";
        $transaction_id = session('transaction_id');
        $response_url = 'http://localhost:8000/payment-response'; // Define a named route for the payment response
        $email = Auth::user()->email; // Retrieve authenticated user's email
        $customer_id = session('std_no'); // Retrieve from session
        $phone_no = session('phone_no');  // Get the phone number from your logic
        $secretKey = "c4502d31091fdd578dbdde27e09cc490942d4565c7b53323ced238d59aa3ae43";
        $payment_params = json_encode(['Acceptance Fee' => ['amount' => $amounttopay, 'code' => 'FLKACCOYLV001']]);

        $string2hash = $merchant_id . $product_id . $product_description
            . $total_amount_due . $currency . $transaction_id . $customer_id . $email . $phone_no
            . $payment_params . $response_url . $secretKey;

        $hashed_string = hash('sha256', $string2hash);

        $data = [
            'account_id' => session('account_id'),
            'wallet_id' => session('wallet_id'),
            'std_no' => session('std_no'),
            'full_name' => session('full_name'),
            'email' => session('email'),
            'phone_no' => session('phone_no'),
            'std_course' => session('std_course'),
            'amount' => session('amount'),
            'amount_due' => session('amount_due'),
            'transaction_id' => session('transaction_id'), 
            //-----payment integration details-----
            'merchant_id' => $merchant_id,
            'product_id' => $product_id,
            'product_description' => $product_description,
            'total_amount_due' => $total_amount_due,
            'currency' => $currency,
            'response_url' => $response_url,
            'payment_params' => $payment_params,
            'hashed_string' => $hashed_string,          
            

        ];

        return view('payment.load-wallet-payment-page',compact('data'));
    }

    //--online testing for response fro flicks api
    public function paymentResponse(Request $request)
    {
        $transaction_id = $request->input('transaction_id');
        $rqr_transref = $request->input('transaction_id');
        $rqr_amount = $request->input('amount');

        $merchant_id = "FLKOYSCHST001";
        $product_id = "FLKISWCP001";
        $requeryAmt = ($rqr_amount * 100);
        $secretKey = "c4502d31091fdd578dbdde27e09cc490942d4565c7b53323ced238d59aa3ae43";
        $rqryTransaction_id = $rqr_transref;
        $requeryString2hash = $merchant_id . $product_id . $rqryTransaction_id . $secretKey;
        $requeryHashedValue = hash('sha256', $requeryString2hash);
        $setRequestHeaders = ["Hash: " . $requeryHashedValue];

        $requeryURL = "https://flickspay.flickstechnologies.com/flk/collections/requery/{$merchant_id}/{$product_id}/{$rqryTransaction_id}/{$requeryAmt}";

        // Make a check call to the requery URL
        $response = Http::withHeaders($setRequestHeaders)
            ->get($requeryURL);

        $result = $response->json();
        $ResponseCode = $result['ResponseCode'];
        $ResponseDesc = $result['ResponseDesc'];
        $flicks_transref = $result['FLKTranxRef'];
        // Store response data in session
        Session::put('response_code', $ResponseCode);
        Session::put('response_desc', $ResponseDesc);
        Session::put('flicks_transref', $flicks_transref);
        

        if (request()->has('response_code') && request('response_code') === '00') {
            return redirect()->route('transaction_successful', ['transaction_id' => $transaction_id]);
        } elseif (request()->has('response_code') && request('response_code') === '090') {
            return redirect()->route('transaction_failed', ['transaction_id' => $transaction_id]);
        } else {
            return redirect()->route('transaction_failed', ['transaction_id' => $transaction_id]);
        }
        //return view('wallet');
    }

    //-- local testing for response
    public function flicksPay()
    {
        $transaction_id = session('transaction_id');
        //--test for successful transactions
        $response_code = '00';
        //--test for failed transactions
         //$response_code = '090';
        //$response_desc = 'Approved by financial institution';
        //session(['response_desc' => $response_desc]);

        if ($response_code === '00') {
            return redirect()->route('transaction_successful', ['transaction_id' => $transaction_id]);
        } elseif ($response_code === '090') {
            return redirect()->route('transaction_failed', ['transaction_id' => $transaction_id]);
        } else {
            // Handle other cases or redirect to a default route
            // return redirect()->route('defaultRouteName');
        }
        //return view('wallet');
    }

    public function transactionSuccessful($transaction_id) 
    {
        //--update transaction after successful--
        $response_code = session('response_code');
        $response_desc = session('response_desc');
        $flicks_transref = session('flicks_transref');
        // Find the wallet transaction by transaction ID
        $transaction = wallet_transaction::where('transaction_id', $transaction_id)->first();

        if ($transaction) {
            // Update the transaction status
            $transaction->transaction_status = 'successful';
            $transaction->response_code = $response_code;
            $transaction->response_status = $response_desc;
            $transaction->flicks_transaction_id = $flicks_transref;
            $transaction->save();

            
            // Retrieve user and update funded amount
            $user = User::find($transaction->account_id);           
            // amount funded
            $amount = $transaction->amount;
            // Retrieve the user's total money spent
            $total_money_spent = $user->total_money_spent;
            // Retrieve the user's wallet balance
            $wallet_balance = $user->wallet_balance;
            // Add total money spent to the funded amount
            $user->total_money_spent = $amount + $total_money_spent;
            $user->wallet_balance = $amount + $wallet_balance;
            $user->save();

            // Flash a success message to the session
            Session::flash('success', 'Your transaction was successful!');

            return redirect()->route('send-mail-success', ['transaction_id' => $transaction_id]);
        } else {
            // Flash an error message to the session
            Session::flash('error', 'Your transaction was not successful.');

            return redirect()->route('send-mail-failed', ['transaction_id' => $transaction_id]);
        }

    }

    public function transactionFailed($transaction_id) 
    {
        //--update transaction after successful--
        $response_code = session('response_code');
        $response_desc = session('response_desc');
        $flicks_transref = session('flicks_transref');
        // Find the wallet transaction by transaction ID
        $transaction = wallet_transaction::where('transaction_id', $transaction_id)->first();

        if ($transaction) {
            // Update the transaction status
            $transaction->transaction_status = 'failed';
            $transaction->response_code = $response_code;
            $transaction->response_status = $response_desc;
            $transaction->flicks_transaction_id = $flicks_transref;
            $transaction->save();  

            // Flash an error message to the session
            Session::flash('error', 'Your transaction was not successful.');
            
            return redirect()->route('send-mail-failed', ['transaction_id' => $transaction_id]);
        } else {
            // Flash an error message to the session
            Session::flash('error', 'Your transaction was not successful.');

            return redirect()->route('send-mail-failed', ['transaction_id' => $transaction_id]);
        }

    }

    //--pay from wallet
    public function payWallet()
    {
        $std_course = auth()->user()->std_course;
        $std_state = auth()->user()->std_state;
        $std_no = auth()->user()->std_no;
        $academic_level = $this->getAcademicLevel($std_no);

        //----retrieve current academic session 
        $secondDbData = DB::connection('mysql_second')
                        ->table('collegesetup')
                        ->select('session1')
                        ->get();
                        
        //--------get acceptance fee
        $result = [];

    foreach ($secondDbData as $item) {
        Session::put('stdSession', $item->session1);
        // Use the 'session1' value to query another table
        $acceptanceData = DB::connection('mysql_second')
                        ->table('paymentsetup')
                        ->where('session1', $item->session1)
                        ->where('feetype', 'ACCEPTANCE')
                        ->get();

        //--- get data for school fee-----
        $schfeeData = DB::connection('mysql_second')
                        ->table('payment')
                        ->where('session', $item->session1)
                        ->where('course', $std_course)
                        ->where('state', $std_state)
                        ->where('level', $academic_level)
                        ->get();

        //--- get data for departmental fee-----
        $deptfeeData = DB::connection('mysql_second')
                        ->table('deptfee')
                        ->where('session1', $item->session1)
                        ->where('course', $std_course)
                        ->where('epay', 'YES')
                        ->where('level', $academic_level)
                        ->first();
                       // ->get();

        // You can do further processing if needed
        // For example, appending the session data to the result array
        $result[] = [
            'session' => $item->session1,            
            'acceptanceData' => $acceptanceData,
            'schfeeData' => $schfeeData,
            'deptfeeData' => $deptfeeData,
            'paymentlevel' => $academic_level,
        ];
     }

        return view('payment.pay-wallet', ['result' => $result]);
    }

    //-----Acceptance Fee functions---------------

    public function payWalletAcceptance($totalFee)
    {
        $std_no = auth()->user()->std_no;

    // Check if the user has paid before in the 'acceptance' table
    $hasPaid = DB::connection('mysql_second')
                ->table('acceptance')
                ->where('matricno', $std_no)
                ->exists();

        if ($hasPaid) {
            return redirect()->route('pay-wallet')->with('success', 'Acceptance fee has been fully paid.');
        } else {
            Session::put('totalFee', $totalFee);
            //return view('payment.pay-wallet-acceptance-view', ['totalFee' => $totalFee]);
            return redirect()->route('pay-wallet-acceptance-view');
        }
    }

    public function payWalletAcceptanceView()
    {
        $std_no = auth()->user()->std_no;
        $academic_level = $this->getAcademicLevel($std_no);
        $totalFee = Session::get('totalFee', 0);
        $stdSession = Session::get('stdSession');
        return view('payment.pay-wallet-acceptance-view', [
            'totalFee' => $totalFee,
            'academicLevel' => $academic_level  ,
            'stdSession' => $stdSession
         ]);
    }

    public function payWalletAcceptanceAction(Request $request)
    {
        //---validate fields--
        $validator = Validator::make($request->all(), [
            'std_state' => 'required',
            'full_name' => 'required',
            'std_no' => 'required',
            'email' => 'required',
            'phone_no' => 'required',
            'amount' => 'required',
            'std_course' => 'required',
            'std_level' => 'required',
            'std_session' => 'required'
            
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        //---------create payment transaction for user in the acceptance table
        $yearkeep = date('Y');
        $monthkeep = date('m');
        $daykeep = date('d');
        $transno = "WAF" . $yearkeep.$monthkeep.$daykeep . substr(uniqid(), 7, 4);
        StudentAcceptance::create([
            'state' => $request->std_state,
            'gender' => '',
            'fullname'  => $request->full_name,
            'matricno'  => $request->std_no,
            'emailaddy' => $request->email,
            'mobileno'  => $request->phone_no,
            'amounttopay'   => $request->amount,
            'amountpaid'   => $request->amount,
            'balance' => 0,
            'course' => $request->std_course,
            'level' => $request->std_level,
            'feetype'   => 'ACCEPTANCE FEE',
            'bankname'  => 'FCMB',
            'tellerno'  => 'xxx0000',
            'session1'  => $request->std_session,
            'paymentdate'   => date('Y-m-d H:i:s'),
            'date1' => date('Y-m-d H:i:s'),
            'confirmby' => 'Applicant',
            'transno'   => $transno,
            'paymode'   => 'WALLET PAYMENT',
            // Add any other relevant fields
        ]);

        //----create transaction in the wallet transaction history
        wallet_transaction::create([

            'account_id' => $request->account_id,
            'wallet_id' => $request->wallet_id,
            'std_no' => $request->std_no,            
            'full_name' => $request->full_name,
            'email' => $request->email,
            'phone_no' => $request->phone_no,
            'std_course' => $request->std_course,
            'amount' => $request->amount,
            'amount_due' => $request->amount,
            'transaction_id' => $transno,
            'transaction_type' => 'Pay from wallet-ACCEPTANCE FEE',
            'transaction_status' => 'successful',
            'transaction_date' => date('Y-m-d H:i:s'),
            'response_code' => '',
            'response_status' => '',
            'flicks_transaction_id' => ''            

        ]);

        //----debit user wallet account and update balance---
        $user = User::where('id', auth()->user()->id)->first();
        $totalFee = $request->amount;

        if ($user) {
            $wallet_balance = $user->wallet_balance;
            if ($wallet_balance > $totalFee) {
                // Debit the wallet balance
                $new_wallet_balance = $wallet_balance - $totalFee;                
                $user->wallet_balance = $new_wallet_balance;
                $user->save();
                //----pass data
                $walletdata = [

                    'full_name' => $user->full_name,
                    'wallet_id' => $user->wallet_id,
                    'amount' => $request->amount,
                    'wallet_balance' => $new_wallet_balance,
                    'transaction_type' => 'Pay from wallet-ACCEPTANCE FEE',
                    'email' => $request->email,
                ];
                //------
                return redirect()->route('send-mail-pay-wallet', $walletdata);
            } else {
                // Handle insufficient balance scenario
                return redirect()->route('pay-wallet-acceptance-view')->with('error', 'Insufficient balance in wallet.');
            }

        }
    }

    //----End of Acceptance fee functions-----------    
    //--------School Fee Functions
    public function payWalletSchoolFee($totalFee)
    {
        $std_no = auth()->user()->std_no;
        $std_course = auth()->user()->std_course;
        $std_state = auth()->user()->std_state;
        $std_session = Session::get('stdSession');
        $std_level = $this->getAcademicLevel($std_no);
        
    // Check if the user has paid before in the 'stdpaymentacct' table
    $hasPaid = DB::connection('mysql_second')
                ->table('stdpaymentacct')
                ->where('matricno', $std_no)
                ->where('session1', $std_session)
                ->where('paymentlevel', $std_level)
                ->first();
    // check for the payment breakkdown for the user----
    $userFee = DB::connection('mysql_second')
                ->table('payment')
                ->where('course', $std_course)
                ->where('state', $std_state)
                ->where('session', $std_session)
                ->where('level', $std_level)
                ->first();

        $tutionfee = null; 
        $otherfee = null;

        if ($userFee) {
                    $tutionfee = $userFee->tutionfee; 
                    $otherfee = $userFee->otherfee;
            }
        //-------------------------------------------- 
        $feestatus = null;          
        if ($hasPaid) {
            $feestatus = $hasPaid->feestatus;
            //----
            if ($feestatus=='full') {
                return redirect()->route('pay-wallet')->with('success', 'School fee has been fully paid.');
            }
            elseif ($feestatus=='part') {
               
                    $totalfee  = $hasPaid->amounttopay;
                    $amountpaid = $hasPaid->amountpaid;
                    $balance = $hasPaid->balance;
                    Session::put('balance', $balance);
                    Session::put('amountpaid', $amountpaid);
                    Session::put('totalfee', $totalfee);
                    Session::put('std_level', $std_level);
                    Session::put('std_session', $std_session);
                    Session::put('tutionfee', $tutionfee);
                    Session::put('otherfee', $otherfee);
               
                    return redirect()->route('pay-wallet-school-fee-view');
            }
            //---------------------            
        } else {
            Session::put('tutionfee', $tutionfee);
            Session::put('otherfee', $otherfee);
            Session::put('totalFee', $totalFee);
            //create a new payment transaction in stdpaymentacct table
            $user = Auth::user();
            StudentPaymentAcct::create([
                'state' => $user->std_state,
                'gender' => '',
                'fullname' => $user->full_name,
                'matricno'  => $user->std_no,
                'emailaddy' => $user->email,
                'mobileno'  => $user->phone_no,
                'amounttopay' =>$totalFee,
                'amountpaid'   => 0,
                'balance' => $totalFee,
                'course'   => $user->std_course,
                'academiclevel' => $std_level,
                'paymentlevel' => $std_level,
                'feestatus' => 'part',
                'session1' => $std_session,
                'confirmby' => 'Applicant',
                'tutionfee'  => $tutionfee,
                'otherfee' => $otherfee,
                'deptfee' => 0,
                'totalfee'  => $totalFee,
                'percentstatus' => 'NO',
                'percentvalue' => 0
            ]);
                    $totalfee  = $totalFee;
                    $amountpaid = 0;
                    $balance = $totalFee;

                    Session::put('balance', $balance);
                    Session::put('amountpaid', $amountpaid);
                    Session::put('totalfee', $totalfee);
                    Session::put('std_level', $std_level);
                    Session::put('std_session', $std_session);
               
                    return redirect()->route('pay-wallet-school-fee-view');
        }
    }

    public function payWalletSchoolFeeView()
    {
        $std_no = auth()->user()->std_no;
        $academic_level = $this->getAcademicLevel($std_no);
        $totalFee = Session::get('totalFee', 0);
        $amountpaid = Session::get('amountpaid', 0);
        $balance = Session::get('balance', 0);
        $stdSession = Session::get('stdSession');
        $tutionfee = Session::get('tutionfee', 0);
        $otherfee = Session::get('otherfee', 0);
        return view('payment.pay-wallet-school-fee-view', [
            'totalFee' => $totalFee,
            'academicLevel' => $academic_level  ,
            'stdSession' => $stdSession,
            'amountpaid' => $amountpaid,
            'tutionfee' => $tutionfee,
            'otherfee' => $otherfee,
            'balance' => $balance
         ]);
    }

    public function payWalletSchoolFeeAction(Request $request)
    {
        $pay_type = trim($request->pay_type);
        //dd($pay_type);
        //get the fee values----
        $std_no = auth()->user()->std_no;
        $std_course = auth()->user()->std_course;
        $std_state = auth()->user()->std_state;
        $std_session = Session::get('stdSession');
        $std_level = $this->getAcademicLevel($std_no);

        $userFee = DB::connection('mysql_second')
                ->table('payment')
                ->where('course', $std_course)
                ->where('state', $std_state)
                ->where('session', $std_session)
                ->where('level', $std_level)
                ->first();

        $tutionfee = null; 
        $otherfee = null;

        if ($userFee) {
                    $tutionfee = $userFee->tutionfee; 
                    $otherfee = $userFee->otherfee;
                    $totalfee = $userFee->total;
                    Session::put('tutionfee', $tutionfee);
                    Session::put('otherfee', $otherfee);
                    Session::put('totalfee', $totalfee);
            }

            if ($pay_type == 'Tuition Fee and Other Charges') {
                Session::put('amountpaid', $totalfee);
                Session::put('transaction_name', 'TUITION FEE AND OTHER CHARGES');
                return redirect()->route('handle-all-payment');
                //$this->handleAllPayment();  

            } 
            else if ($pay_type == 'Tuition Fee') {
                Session::put('amountpaid', $tutionfee);
                Session::put('transaction_name', 'TUITION FEE');
                return redirect()->route('handle-all-payment');
            } 
            else if ($pay_type == 'Other Charges') {
                Session::put('amountpaid', $otherfee);
                Session::put('transaction_name', 'OTHER CHARGES');
                return redirect()->route('handle-all-payment');
            }
            else {
                return redirect()->route('pay-wallet-school-fee-view')->with('error', 'Select what you are paying for.');
            }
            
    }    
    //---Payment for both tuition fee and other charges--
    public function handleAllPayment()
    {        
        $user = Auth::user();
        $std_session = Session::get('stdSession');
        $transaction_name = Session::get('transaction_name');
        $amountpaid = Session::get('amountpaid'); 
        $std_no = $user->std_no;
        $std_level = $this->getAcademicLevel($std_no);   
        $wallet_balance = $user->wallet_balance; 
        //dd($wallet_balance, $std_session, $std_level, $std_no);

        // Check if wallet balance is sufficient        
        if ($wallet_balance >= $amountpaid) {
            // Check if user's payment account exists for the session and level
            $paymentAccountExists = StudentPaymentAcct::where('matricno', $std_no)
                ->where('session1', $std_session)
                ->where('paymentlevel', $std_level)
                ->first();  

            if ($paymentAccountExists) {   
                //----get user payment details from stdpaymentacct table----             
            $userCurrentBalance = $paymentAccountExists->balance; 
            $userCurrentAmountPaid = $paymentAccountExists->amountpaid;                                     
                // Create a payment transaction in stdpayment table
            $yearkeep = date('Y');
            $monthkeep = date('m');
            $daykeep = date('d');
            $transaction_id = "WSF" . $yearkeep.$monthkeep.$daykeep . substr(uniqid(), 7, 4);
            StudentPayment::create([
                    'transno' => $transaction_id,
                    'fullname' => $user->full_name,
                    'matricno'  => $user->std_no,
                    'emailaddy' => $user->email,
                    'mobileno'  => $user->phone_no,
                    'bankname' => 'FCMB',
                    'feetype' => $transaction_name,
                    'feeamount'   => $amountpaid,
                    'course'   => $user->std_course,
                    'level' => $std_level,
                    'session1' => $std_session,
                    'tellerno' => 'WA'. $user->std_no,
                    'paymentdate' => date('Y-m-d H:i:s'),
                    'paymentdate1' => date('Y-m-d H:i:s'),
                    'date1' => date('Y-m-d H:i:s'),
                    'picturename'  => $user->std_no . '.jpg',
                    'confirmby' => "Applicant",
                    'percentstatus' => 'NO',
                    'state' => $user->std_state,
                    'gender' => '',
                    'paymode' => 'WALLET PAYMENT'
            ]);            

            //update user payment in stdpaymentacct table
                $userNewBalance = $userCurrentBalance - $amountpaid;
                $userNewAmountPaid = $userCurrentAmountPaid + $amountpaid;
                //----check balance
                if($userNewBalance == 0) {
                    $feestatus = 'full';
                }
                elseif($userNewBalance > 0) {
                    $feestatus = 'part';
                }  
                StudentPaymentAcct::where('matricno', $std_no)
                ->where('session1', $std_session)
                ->where('paymentlevel', $std_level)
                ->update([
                    'amountpaid' => $userNewAmountPaid,
                    'balance' => $userNewBalance,
                    'feestatus' => $feestatus,
                ]);                
            //------------------
            // Update user's wallet balance
                $wallet_balance = $user->wallet_balance;
                $new_wallet_balance = $wallet_balance - $amountpaid;                
                $user->wallet_balance = $new_wallet_balance;
                $user->save();

            //----create transaction in the wallet transaction history
            wallet_transaction::create([

            'account_id' => $user->id,
            'wallet_id' => $user->wallet_id,
            'std_no' => $user->std_no,            
            'full_name' => $user->full_name,
            'email' => $user->email,
            'phone_no' => $user->phone_no,
            'std_course' => $user->std_course,
            'amount' => $amountpaid,
            'amount_due' => $amountpaid,
            'transaction_id' => $transaction_id,
            'transaction_type' => 'Pay from wallet-' . $transaction_name,
            'transaction_status' => 'successful',
            'transaction_date' => date('Y-m-d H:i:s'),
            'response_code' => '',
            'response_status' => '',
            'flicks_transaction_id' => ''            

        ]); 
            $walletdata = [

                    'full_name' => $user->full_name,
                    'wallet_id' => $user->wallet_id,
                    'amount' => $amountpaid,
                    'wallet_balance' => $new_wallet_balance,
                    'transaction_type' => 'Pay from wallet-' . $transaction_name,
                    'email' => $user->email,
                ];
                //------
            return redirect()->route('send-mail-pay-wallet', $walletdata);
                
               
            }
            //----if user payment account does not exist
            else {                
                return redirect()->route('dashboard')->with('error', 'There is a problem with your payment, please contact the ICT center.'); 
            }            
            
        } else {
            // Handle insufficient wallet balance scenario
            return redirect()->route('pay-wallet-school-fee-view')->with('error', 'Insufficient Funds, please fund your wallet.');
        }

    }    
    
    //----End of School fee functions----------- 
    //--------Departmental Fee Functions
    public function payWalletDeptFee($totalFee)
    {
        $std_no = auth()->user()->std_no;
        $std_course = auth()->user()->std_course;
        $std_state = auth()->user()->std_state;
        $std_session = Session::get('stdSession');
        $std_level = $this->getAcademicLevel($std_no);
        
    // Check if the user has paid before in the 'stdpaymentacct' table
    $hasPaid = DB::connection('mysql_second')
                ->table('deptfee1')
                ->where('matricno', $std_no)
                ->where('session1', $std_session)
                ->where('paymentlevel', $std_level)
                ->first();
    // check for the payment breakdown for the user----
    $DeptFeeOnline = DB::connection('mysql_second')
                ->table('deptfee')
                ->where('course', $std_course)
                ->where('session1', $std_session)
                ->where('level', $std_level)
                ->where('epay', 'YES')
                ->get();     
    //------------------------------
    $DeptFeeBank = DB::connection('mysql_second')
                ->table('deptfee')
                ->where('course', $std_course)
                ->where('session1', $std_session)
                ->where('level', $std_level)
                ->where('epay', 'NO')
                ->get(); 

        //-------------------------------------------- 
        $feestatus = null;          
        if ($hasPaid) {
            $feestatus = $hasPaid->feestatus;
            //----
            if ($feestatus=='full') {
                return redirect()->route('pay-wallet')->with('success', 'Departmental fee has been fully paid.');
            }
            elseif ($feestatus=='part') {
               
                    $totalfee  = $hasPaid->amounttopay;
                    $amountpaid = $hasPaid->amountpaid;
                    $balance = $hasPaid->balance;
                    Session::put('balance', $balance);
                    Session::put('amountpaid', $amountpaid);
                    Session::put('totalfee', $totalfee);
                    Session::put('std_level', $std_level);
                    Session::put('std_session', $std_session);
                    //------     
                    return redirect()->route('pay-wallet-dept-fee-view', compact('DeptFeeOnline','DeptFeeBank'));
            }
            //---------------------            
        } else {            
            Session::put('totalFee', $totalFee);
            //create a new payment transaction in stdpaymentacct table
            $user = Auth::user();
            DeptPaymentAcct::create([
                'state' => $user->std_state,
                'gender' => '',
                'fullname' => $user->full_name,
                'matricno'  => $user->std_no,
                'emailaddy' => $user->email,
                'mobileno'  => $user->phone_no,
                'amounttopay' =>$totalFee,
                'amountpaid'   => 0,
                'balance' => $totalFee,
                'course'   => $user->std_course,
                'academiclevel' => $std_level,
                'paymentlevel' => $std_level,
                'feestatus' => 'part',
                'session1' => $std_session,
                'confirmby' => 'Applicant',
                'totalfee'  => $totalFee
            ]);
                    $totalfee  = $totalFee;
                    $amountpaid = 0;
                    $balance = $totalFee;

                    Session::put('balance', $balance);
                    Session::put('amountpaid', $amountpaid);
                    Session::put('totalfee', $totalfee);
                    Session::put('std_level', $std_level);
                    Session::put('std_session', $std_session);
               
                    return redirect()->route('pay-wallet-dept-fee-view', compact('DeptFeeOnline','DeptFeeBank'));
        }
    }

    public function payWalletDeptFeeView()
    {
        $std_no = auth()->user()->std_no;
        $std_course = auth()->user()->std_course;
        $academic_level = $this->getAcademicLevel($std_no);
        $totalFee = Session::get('totalFee', 0);
        $amountpaid = Session::get('amountpaid', 0);
        $balance = Session::get('balance', 0);
        $stdSession = Session::get('stdSession');
        // check for the payment breakdown for the user----
        $DeptFeeOnline = DB::connection('mysql_second')
        ->table('deptfee')
        ->where('course', $std_course)
        ->where('session1', $stdSession)
        ->where('level', $academic_level)
        ->where('epay', 'YES')
        ->get();     
    //------------------------------
        $DeptFeeBank = DB::connection('mysql_second')
            ->table('deptfee')
            ->where('course', $std_course)
            ->where('session1', $stdSession)
            ->where('level', $academic_level)
            ->where('epay', 'NO')
            ->get(); 

        return view('payment.pay-wallet-dept-fee-view',compact('DeptFeeOnline','DeptFeeBank') ,
        [
            'totalFee' => $totalFee,
            'academicLevel' => $academic_level  ,
            'stdSession' => $stdSession,
            'amountpaid' => $amountpaid,
            'balance' => $balance
         ]);
    }
    
    public function payWalletDeptFeeAction($payid)
    {
        $deptFeeRecord = DB::connection('mysql_second')
            ->table('deptfee')
            ->where('ID', $payid)
            ->first();             

            $user = Auth::user();
            $std_session = Session::get('stdSession');
            $transaction_name = 'DEPARTMENTAL FEE';
            $amountpaid = $deptFeeRecord->fee2;
            $std_no = $user->std_no;
            $std_level = $this->getAcademicLevel($std_no);   
            $wallet_balance = $user->wallet_balance; 
            //dd($wallet_balance, $std_session, $std_level, $std_no);

            $userHasPaid = DB::connection('mysql_second')
            ->table('deptpayment')
            ->where('matricno', $std_no)
            ->where('level', $std_level)
            ->where('session1', $std_session)
            ->where('feeamount', $amountpaid)
            ->first(); 

            if($userHasPaid){
                return redirect()->route('pay-wallet-dept-fee-view')->with('error', 'The payment of =N=' .$amountpaid. ' has been made already.'); 
            }

            // Check if wallet balance is sufficient        
            if ($wallet_balance >= $amountpaid) {
                // Check if user's payment account exists for the session and level
                $paymentAccountExists = DeptPaymentAcct::where('matricno', $std_no)
                    ->where('session1', $std_session)
                    ->where('paymentlevel', $std_level)
                    ->first();  
    
                if ($paymentAccountExists) {   
                    //----get user payment details from deptfee1 table----             
                $userCurrentBalance = $paymentAccountExists->balance; 
                $userCurrentAmountPaid = $paymentAccountExists->amountpaid;                                     
                    // Create a payment transaction in deptpayment table
                $yearkeep = date('Y');
                $monthkeep = date('m');
                $daykeep = date('d');
                $transaction_id = "WDF" . $yearkeep.$monthkeep.$daykeep . substr(uniqid(), 7, 4);
                DeptPayment::create([
                        'transno' => $transaction_id,
                        'fullname' => $user->full_name,
                        'matricno'  => $user->std_no,
                        'emailaddy' => $user->email,
                        'mobileno'  => $user->phone_no,
                        'bankname' => 'FCMB',
                        'feetype' => $transaction_name,
                        'feeamount'   => $amountpaid,
                        'course'   => $user->std_course,
                        'level' => $std_level,
                        'session1' => $std_session,
                        'tellerno' => 'WA'. $user->std_no,
                        'paymentdate' => date('Y-m-d H:i:s'),
                        'paymentdate1' => date('Y-m-d H:i:s'),
                        'date1' => date('Y-m-d H:i:s'),
                        'picturename'  => $user->std_no . '.jpg',
                        'confirmby' => "Applicant",
                        'state' => $user->std_state,
                        'gender' => '',
                        'paymode' => 'WALLET PAYMENT'
                ]);            
    
                //update user payment in stdpaymentacct table
                    $userNewBalance = $userCurrentBalance - $amountpaid;
                    $userNewAmountPaid = $userCurrentAmountPaid + $amountpaid;
                    //----check balance
                    if($userNewBalance == 0) {
                        $feestatus = 'full';
                    }
                    elseif($userNewBalance > 0) {
                        $feestatus = 'part';
                    }  
                    DeptPaymentAcct::where('matricno', $std_no)
                    ->where('session1', $std_session)
                    ->where('paymentlevel', $std_level)
                    ->update([
                        'amountpaid' => $userNewAmountPaid,
                        'balance' => $userNewBalance,
                        'feestatus' => $feestatus,
                    ]);                
                //------------------
                // Update user's wallet balance
                    $wallet_balance = $user->wallet_balance;
                    $new_wallet_balance = $wallet_balance - $amountpaid;                
                    $user->wallet_balance = $new_wallet_balance;
                    $user->save();
    
                //----create transaction in the wallet transaction history
                wallet_transaction::create([
    
                'account_id' => $user->id,
                'wallet_id' => $user->wallet_id,
                'std_no' => $user->std_no,            
                'full_name' => $user->full_name,
                'email' => $user->email,
                'phone_no' => $user->phone_no,
                'std_course' => $user->std_course,
                'amount' => $amountpaid,
                'amount_due' => $amountpaid,
                'transaction_id' => $transaction_id,
                'transaction_type' => 'Pay from wallet-' . $transaction_name,
                'transaction_status' => 'successful',
                'transaction_date' => date('Y-m-d H:i:s'),
                'response_code' => '',
                'response_status' => '',
                'flicks_transaction_id' => ''            
    
            ]); 
                $walletdata = [
    
                        'full_name' => $user->full_name,
                        'wallet_id' => $user->wallet_id,
                        'amount' => $amountpaid,
                        'wallet_balance' => $new_wallet_balance,
                        'transaction_type' => 'Pay from wallet-' . $transaction_name,
                        'email' => $user->email,
                    ];
                    //------
                return redirect()->route('send-mail-pay-wallet', $walletdata);
                    
                   
                }
                //----if user payment account does not exist
                else {                
                    return redirect()->route('dashboard')->with('error', 'There is a problem with your payment, please contact the ICT center.'); 
                }            
                
            } else {
                // Handle insufficient wallet balance scenario
                return redirect()->route('pay-wallet-dept-fee-view')->with('error', 'Insufficient Funds, please fund your wallet.');
            }
    


        return view('your.view', compact('deptFeeRecord'));
    }


    private function getAcademicLevel($std_no)
    {
        // Check 'application' table for student number
        $applicationData = DB::connection('mysql_second')
                            ->table('application')
                            ->where('applicationno', $std_no)
                            ->first();

        if ($applicationData) {
            return $applicationData->academiclevel;
        }

        // Check 'student' table if not found in 'application' table
        $studentData = DB::connection('mysql_second')
                        ->table('student')
                        ->where('matricno', $std_no)
                        ->first();

        if ($studentData) {
            return $studentData->paymentlevel;
        }

        return null; // Student number not found
    }

    //-----Fund Transaction functions---------

    //--transfer from wallet
    public function payOtherWallet()
    {
        return view('payment.pay-other-wallet');
    }

    public function payOtherWalletAction(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'wallet_id' => 'required',
        ]);
    
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
    
        $walletID = $request->input('wallet_id');
    
        // Check if the wallet ID exists in the database
        $user = User::where('wallet_id', $walletID)->first();
    
        if (!$user) {
            // Redirect back with an error message
            return redirect()->back()->withErrors(['wallet_id' => trans('auth.failed')])->withInput();
        }
    
        // Check if the entered wallet ID is the same as the logged-in user's wallet ID
        if ($user->wallet_id === auth()->user()->wallet_id) {
            // Redirect back with an error message indicating the same wallet ID
            return redirect()->back()->withErrors(['wallet_id' => 'The wallet ID you entered is assigned to you, enter a different wallet ID.'])->withInput();
        }
    
        return view('payment.pay-other-wallet-verify', [
            'account_id' => $user->id,
            'wallet_id' => $user->wallet_id,
            'full_name' => $user->full_name,
            'phone_no' => $user->phone_no,
            'email' => $user->email,
            'std_course' => $user->std_course,
            'std_no' => $user->std_no, 
            'wallet_balance' => $user->wallet_balance,
            'total_money_recieved' => $user->total_money_recieved,
        ]);  
     
    }

    //--Save fund transfer 
    public function payOtherWalletSave(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'amount' => 'required', // Add more validation rules here if needed
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        //----check if amount is not greater than the sender balance
        $amount = $request->amount;
        $sender_wallet_id = $request->sender_wallet_id;
        $reciever_wallet_id = $request->reciever_wallet_id;
        $sender_wallet_balance = $request->sender_wallet_balance;
        $reciever_wallet_balance = $request->reciever_wallet_balance;
        $sender_total_money_transfer = $request->sender_total_money_transfer;
        $reciever_total_money_recieved = $request->reciever_total_money_recieved;
        //---------------------------------------
        if($sender_wallet_balance < $amount) {
            return redirect()->route('dashboard')->with('error', 'Insufficient funds.');
        }

        //---create new transaction
        TransferFund::create([

            'sender_account_id' => $request->sender_account_id,
            'reciever_account_id' => $request->reciever_account_id,
            'sender_email' => $request->sender_email,
            'reciever_email' => $request->reciever_email,
            'sender_full_name' => $request->sender_full_name,
            'reciever_full_name' => $request->reciever_full_name,
            'sender_phone_no' => $request->sender_phone_no,
            'reciever_phone_no' => $request->reciever_phone_no,
            'sender_wallet_id' => $request->sender_wallet_id,
            'reciever_wallet_id' => $request->reciever_wallet_id,
            'amount' => $request->amount,
            'transaction_type' => 'Fund Transfer',
            'transaction_status' => 'Successful'

        ]);
      
        //---debit the sender and update wallet balance and total funds transferred----
        $newSenderBalance = $sender_wallet_balance - $amount;

        $userSender = User::where('wallet_id', $sender_wallet_id)->first();
        if ($userSender) {
            $userSender->update([
                'wallet_balance' => $newSenderBalance,
                'total_money_transfer' => $sender_total_money_transfer + $amount,
            ]);
        }
        //--------------------------------------------------------------------------

        //---credit the receiver and update wallet balance and total funds received----
        $newReceiverBalance = $reciever_wallet_balance + $amount;

        $userReceiver = User::where('wallet_id', $reciever_wallet_id)->first();
        if ($userReceiver) {
            $userReceiver->update([
                'wallet_balance' => $newReceiverBalance,
                'total_money_recieved' => $reciever_total_money_recieved + $amount,
            ]);
        }
        //----------------------------------------------------------------------------

        $userdata = [
            'sender_wallet_id' => $request->sender_wallet_id,
            'reciever_wallet_id' => $request->reciever_wallet_id,
            'amount' => $request->amount,
            'sender_wallet_balance' => $newSenderBalance,
            'reciever_wallet_balance' => $newReceiverBalance,
            'sender_email' => $request->sender_email,
            'reciever_email' => $request->reciever_email,
            'sender_full_name' => $request->sender_full_name,
            'reciever_full_name' => $request->reciever_full_name,
            
        ];

        return redirect()->route('send-mail-fund-transfer', $userdata);
    }

    //--pay from wallet
    public function refundBank()
    {
        return view('pages.refund-bank');
    }

    //--Fund wallet transaction history
    public function transactionHistory()
    {
        $userEmail = Auth::user()->email;

        // Query wallet transactions for the authenticated user's email with specific transaction_type and pagination
        $transactionTotal = wallet_transaction::where('email', '=', $userEmail)
        ->where('transaction_status', '=', 'successful')
        ->where('transaction_type', 'LIKE', '%pay from wallet%')
        ->sum('amount');

        // Query wallet transactions for the authenticated user's email with pagination
        $records = wallet_transaction::where('email', '=', $userEmail)
            // ->where('transaction_status', '=', 'successful')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('payment.user-transaction-history', compact('records', 'transactionTotal'));
    }

    //--Fund transfer transaction history
    public function fundTransferHistory()
    {
        $userEmail = Auth::user()->email;

        // Query wallet transactions for the authenticated user's email with specific transaction_type and pagination
        $transactionTotal = wallet_transaction::where('email', '=', $userEmail)
        ->where('transaction_status', '=', 'successful')
        ->where('transaction_type', 'LIKE', '%pay from wallet%')
        ->sum('amount');

        // $records = TransferFund::where(function ($query) use ($userEmail) {
        //     $query->where('sender_email', $userEmail)
        //           ->orWhere('reciever_email', $userEmail);
        // })
        // ->orderBy('created_at', 'desc')
        // ->paginate(10);

        // Query wallet transactions for the authenticated user's email with pagination
        $records = TransferFund::where('sender_email', '=', $userEmail)
            // ->where('transaction_status', '=', 'successful')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('payment.fund-transfer-history', compact('records', 'transactionTotal'));
    }

    //--Fund recieved transaction history
    public function fundRecievedHistory()
    {
        $userEmail = Auth::user()->email;

        // Query wallet transactions for the authenticated user's email with specific transaction_type and pagination
        $transactionTotal = wallet_transaction::where('email', '=', $userEmail)
        ->where('transaction_status', '=', 'successful')
        ->where('transaction_type', 'LIKE', '%pay from wallet%')
        ->sum('amount');

        // Query wallet transactions for the authenticated user's email with pagination
        $records = TransferFund::where('reciever_email', '=', $userEmail)
            // ->where('transaction_status', '=', 'successful')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('payment.fund-recieved-history', compact('records', 'transactionTotal'));
    }

    
}
