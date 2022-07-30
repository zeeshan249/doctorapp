<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserLoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['webValidateLogin']]);
    }
    // To validate the user login with server side validation
    public function webvalidateLogin(Request $request)
    {


        try {


        if ($jwtToken=Auth::attempt(['user_mobile' => $request->user_mobile, 'password' => $request->password,'user_is_active'=>1])) {

            DB::table('dm_user')
                ->join('roles', 'dm_user.role_id', '=', 'roles.id')

                ->where('user_id', Auth::user()->user_id);
            $userData['user_id'] = Auth::user()->user_id;
            $userData['user_mobile'] = Auth::user()->user_mobile;
            $userData['user_is_active'] = Auth::user()->user_is_active;
            $userData['user_first_name'] = 'Admin';
            $userData['user_last_name'] = 'User';
            $userData['user_full_name'] = 'Admin User';
            $userData['user_profile_image'] = 0;
//            $userData['user_email'] = Auth::user()->user_email;
            $roleData= DB::table('dm_user')

                ->join('roles', 'roles.id', '=', 'dm_user.role_id')
                ->where('user_id', Auth::user()->user_id)
                ->select('roles.name','roles.id')->distinct()->get();

            return response()->json(['result' => 'success', 'message' => 'Login Success','token'=>$jwtToken,
              'userData'=>$userData
             ,'roleData'=>$roleData
            ]);
//            return response()->json(['result' => 'success', 'message' => 'Login Success', 'token' => $token,
//                'userData' => $userData]);
        } else {

            // Login Fail
            return response()->json(['result' => 'error', 'message' => 'Invalid Login Details']);
        }
        } catch (Exception $ex) {

            return response()->json(['result' => "exception", 'message' => 'Something went wrong']);
        }

    }
    //User Logout
    public function logout()
    {
        Auth::logout();

    }





}
