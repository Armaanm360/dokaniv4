<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class UserRegistrationController extends Controller
{
    public function userRegisterController(Request $request)
    {


        if ($request->ismethod('post')) {
            $data = $request->all();





            $rules = [
                'name' => 'required',
                'email' => 'required|unique:users',
                'password' => 'required|min:6'
            ];

            $validator =  Validator::make($data, $rules);
            if ($validator->fails()) {
                foreach ($validator->errors()->getMessages() as $key => $value) {
                    $a = array();
                    $a = [
                        'success' => false,
                        'message' => $value[0]
                    ];

                    return response()->json($a);
                    // die;
                }
            }

            $user = new User();
            $user->name  = $data['name'];
            $user->email = $data['email'];
            $user->phone = $data['phone'];
            $user->role  = $data['role'];
            $user->password = bcrypt($data['password']);
            $user->save();




            if (Auth::attempt(['email' => $data['email'], 'password' => $data['password']])) {
                $user = User::where('email', $data['email'])->first();
                $access_token = $user->createToken($data['email'])->accessToken;
                User::where('email', $data['email'])->update(['access_token' => $access_token]);
                $message = 'User Successfully Registerd';
                if (isAPIRequest()) {
                    return response()->json(['message' => $message, 'access_token' => $access_token, 'success' => true,], 201);
                } else {

                    return Redirect::to('/home/');
                }
            } else {
                $message = 'Oppss Something Went Wrong';
                return response()->json(['message' => $message, 'success' => false], 422);
            }
        }
    }


    public function userLoginController(Request $request)
    {
        if ($request->ismethod('post')) {
            $data = $request->all();

            $rules = [
                'email' => 'required|exists:users',
                'password' => 'required'
            ];

            $validator =  Validator::make($data, $rules);
            if ($validator->fails()) {
                foreach ($validator->errors()->getMessages() as $key => $value) {
                    $a = array();
                    $a = [
                        'success' => false,
                        'message' => $value[0],
                    ];
                    return response()->json($a);
                }
            }

            if (Auth::attempt(['email' => $data['email'], 'password' => $data['password']])) {
                $user = User::where('email', $data['email'])->first();
                unset($user['facebook_id'], $user['access_token'], $user['google_id'], $user['google_id'], $user['designation'], $user['institution_id'], $user['description'], $user['slug'], $user['email_verified_at'], $user['ministry_department'], $user['organization_user'], $user['regulatory_authority'], $user['branch_user'], $user['signature'], $user['division'], $user['role'], $user['user_creator'], $user['user_category']);
                $access_token = $user->createToken($data['email'])->accessToken;
                User::where('email', $data['email'])->update(['access_token' => $access_token]);
                $message = 'User Successfully Login';
                return response()->json([
                    'message' => $message,
                    'access_token' => $access_token,
                    'data' =>  $user,
                    'success' => true,
                ], 201);
            } else {
                $message = 'Ooops Something Went Wrong';
                return response()->json(['message' => $message, 'success' => false], 422);
            }
        }
    }
}
