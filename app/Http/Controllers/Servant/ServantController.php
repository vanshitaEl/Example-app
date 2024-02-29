<?php

namespace App\Http\Controllers\Servant;
use App\Models\Servant;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CreateValidationRequest;
use App\Http\Requests\LoginRequest;

class ServantController extends Controller
{
    public function index()
    {
        return view('login');
    }

    public function register()
    {
        return view('registration');
    }

    function save(CreateValidationRequest $request)
    {

        //Validate requests
       // $request->validated();

        //Insert data into database
        // $doctor = new Servant;
        // $doctor->name = $request->name;
        // $doctor->email = $request->email;
        // $doctor->password = Hash::make($request->psw);
        // $save = $doctor->save();

        $save = Servant::create([
            'name' => $request->name,
            'email' => $request->email, 
            'password' => $request->password,
          ]);

        if ($save) {
            return back()->with('success', 'New User has been successfuly added to database');
        } else {
            return back()->with('fail', 'Something went wrong, try again later');
        }
    }

    function check(LoginRequest $request)
    {
        //Validate requests
       // $request->validated();
        $userInfo = Servant::where('email', '=', $request->email)->first();

        if (!$userInfo) {
            return back()->with('fail', 'We do not recognize your email address');
        } else {

            //check password
            if (Hash::check($request->password, $userInfo->password)) {
                // dd($userInfo);
                Auth::guard('servant')->login($userInfo, true);
                return redirect('servant');
            } else {
                return back()->with('fail', 'Incorrect password');
            }
        }
    }
    
    public function logout(){
    Auth::guard('servant')->logout();
    return  redirect()->route('login');
   
 }
}
