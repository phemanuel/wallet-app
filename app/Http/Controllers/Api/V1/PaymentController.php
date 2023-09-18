<?php

namespace App\Http\Controllers\Api\V1;
use App\Models\StudentPaymentAcct;
use App\Http\Controllers\Controller;
use App\Models\wallet_transaction;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Fetch all payment from the stdpaymentacct table
    $userPayment = StudentPaymentAcct::all();

    // Return the list of users as JSON
    return response()->json([
        'message' => 'List of User Payment Account',
        'data' => $userPayment,
    ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $regNo)
    {
        
        // Find the user by their registration number
    $userPay = StudentPaymentAcct::where('matricno', $regNo)->get();

    // Check if the user was found
    if ($userPay->isEmpty()) {
        return response()->json([
            'message' => 'User payment account not found',
        ], 404); // Return a 404 Not Found response if the user is not found
    }

    // Return the user as JSON
    return response()->json([
        'message' => 'User Payment Account',
        'data' => $userPay,
    ]);

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }


    public function walletPage()
    {
        $userWallet = wallet_transaction::paginate(5);

    // Return the list of users as JSON
    return response()->json([
        'message' => 'List of User Payment Account',
        'data' => $userWallet,
    ]);

    // Check if the user was found
    if ($userWallet->isEmpty()) {
        return response()->json([
            'message' => 'User wallet transaction not found',
        ], 404); // Return a 404 Not Found response if the user is not found
    }

    // Return the user as JSON
    return response()->json([
        'message' => 'User wallet transaction',
        'data' => $userWallet,
    ]);
    }

    public function walletView(string $walletid)
    {
        $userWallet = wallet_transaction::where('wallet_id', $walletid)->get();

    // Check if the user was found
    if ($userWallet->isEmpty()) {
        return response()->json([
            'message' => 'User wallet transaction not found',
        ], 404); // Return a 404 Not Found response if the user is not found
    }

    // Return the user as JSON
    return response()->json([
        'message' => 'User wallet transaction',
        'data' => $userWallet,
    ]);
    }

    public function walletPay(string $transaction_id)
    {
        $userWallet = wallet_transaction::where('transaction_id', $transaction_id)->get();

    // Check if the user was found
    if ($userWallet->isEmpty()) {
        return response()->json([
            'message' => 'User wallet transaction not found',
        ], 404); // Return a 404 Not Found response if the user is not found
    }

    // Return the user as JSON
    return response()->json([
        'message' => 'User wallet transaction',
        'data' => $userWallet,
    ]);
    }
}
