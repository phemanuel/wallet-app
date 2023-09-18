<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use App\Models\wallet;
use Intervention\Image\ImageManagerStatic as Image; 

class AuthController extends Controller
{
    //----landing page
    public function home()
    {
        return view('auth.user-login');

    }
    
    //----Account setup page
    public function accountSetup()
    {
        return view('auth.user-account-setup');

    }

    //----view user profile
    public function profile()
    {
        return view('pages.user-profile');

    }

    //----update user profile
    public function profileUpdate(Request $request, string $id)
    {
        $user = User::findOrFail($id);
        $user->update($request->all());
        
        return redirect()->route('profile')->with('success', 'Profile update successful.');
    }

    //----view profile picture----
    public function profilePicture()
    {
        return view('pages.user-profile-picture');

    }

    //update profile picture
    public function profilePictureUpdate(Request $request)
    {
        $user = auth()->user();

         if ($request->hasFile('profile_picture')) {
        $imagePath = $request->file('profile_picture')->store('profile_pictures', 'public');

        // Resize the image using Intervention Image
        $image = Image::make(public_path('storage/' . $imagePath));
        $image->fit(300, 300); // Adjust dimensions as needed
        $image->save();

        // Update user's profile picture
        $user = auth()->user(); // Make sure you have the authenticated user instance
        $user->profile_picture = $imagePath;
        $user->save();

        return redirect()->route('profile-picture')->with('success', 'Profile picture updated successfully.');
    }

        return redirect()->route('profile-picture')->with('error', 'No profile picture provided.');

    }


    //-----view user login form
    public function login()
    {
        return view('auth.user-login');

    }

    //---Account setup function
    public function accountSetupAction(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'std_no' => 'required',
        ]);
    
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
    
        $stdNo = $request->input('std_no');
    
        // Check if the student number exists in the database
        $user = User::where('std_no', $stdNo)->first();
    
        if (!$user) {
            // Redirect back with an error message
            return redirect()->back()->withErrors(['std_no' => trans('auth.failed')])->withInput();
        }
    
        if ($user->account_status == 0) {
            // Redirect to the register page
            return view('auth.user-register', [
                'id' => $user->id,
                'full_name' => $user->full_name,
                'std_course' => $user->std_course,
                'std_no' => $stdNo, // Pass the std_no parameter
            ]); 
        } elseif ($user->account_status == 1) {
            // Redirect to the login page with a message
            return redirect()->route('login')->with('error', 'Your account has already been set up! You can login');
        }   
              

    }

    //---user login function
    public function loginAction(Request $request)
    {
        validator::make($request->all(), [
            'email'=> 'required|email',
            'password' => 'required'

        ])->validate();

        if(!Auth::attempt($request->only('email','password'), $request->boolean('remember'))){
            throw ValidationException::withMessages([
                'email' =>trans('auth.failed')
            ]);
        }

        $request->session()->regenerate();

        return redirect()->route('dashboard');

    }

    //----save user information
    public function registerSave(Request $request,string $id)
    {
        //---validate user information
        validator::make($request->all(), [
            'email'=> 'required|email',
            'phone_no'=> 'required',
            'user_name'=> 'required',
            'password' => 'required|confirmed',
            'full_name' => 'required',
            'gender' => 'required',
            'std_course' => 'required',
            'profile_picture' => 'nullable' // Make the profile picture optional

        ])->validate();

        $user = User::findOrFail($id);
        $user->update($request->all());
        // Store the email address in the session
        session(['email' => $request->input('email')]);
        session(['full_name' => $request->input('full_name')]);
        //session()->flash('success', 'Account setup successful! You can login.');
        
        return redirect('send-mail');  

    }
//----Logout function
    public function logout(Request $request)
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');


    }
}
