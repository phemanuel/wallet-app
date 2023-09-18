<?php

namespace App\Http\Controllers;
use App\Models\wallet_transaction;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Get the authenticated user's email
        $userEmail = Auth::user()->email;

        // Query sum of wallet transactions for the authenticated user's email with specific transaction_type
        $transactionTotal = wallet_transaction::where('email', '=', $userEmail)
        ->where('transaction_status', '=', 'successful')
        ->where('transaction_type', 'LIKE', '%pay from wallet%')
        ->sum('amount');

        // Query wallet transactions for the authenticated user's email with pagination
        $records = wallet_transaction::where('email', '=', $userEmail)
            ->where('transaction_status', '=', 'successful')
            ->orderBy('created_at', 'desc')
            ->paginate(5);

        return view('pages.user-dashboard', compact('records', 'transactionTotal'));
    }
   
}
