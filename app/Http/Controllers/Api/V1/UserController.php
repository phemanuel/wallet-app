<?php

namespace App\Http\Controllers\Api\V1;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Fetch all users from the users table
        $users = User::all();

        // Return the list of users as JSON
        return response()->json([
            'message' => 'List of Users',
            'data' => $users,
        ]);
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
    public function show(string $id)
    {
        // Find the user by their ID
    $user = User::find($id);

    // Check if the user was found
        if (!$user) {
            return response()->json([
                'message' => 'User not found',
            ], 404); 
        }

        // Return the user as JSON
        return response()->json([
            'message' => 'User details',
            'data' => $user,
        ]);
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
}
