<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserDetail;
use Exception;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['register','login']]);
    }

    public function index() {
        return 'Welcome ' . auth()->user()->email;
    }

    public function register(Request $request){
        $this->validate($request, [
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'dateOfBirth' => 'date',
            'phone' => 'string',
            'address' => 'string',
        ]);

        try {

            $user = new User;
            $user->email = $request->input('email');
            $password = $request->input('password');
            $user->password = app('hash')->make($password);
            $user->save();

            $userDetail = new UserDetail;
            $userDetail->name = $request->input('name');
            $userDetail->date_of_birth = $request->input('dateOfBirth');
            $userDetail->phone = $request->input('phone');
            $userDetail->address = $request->input('address');

            $user->user_detail()->save($userDetail);



            $code = 200;
            $output = [
                'user' => $user,
                'code' => $code,
                'message' => 'User created successfully'
            ];



        } catch (Exception $th) {
            return dd($th);
            $code = 500;
            $output = [
                'code' => $code,
                'message' => 'An error occured while creating user.'
            ];
        }

        return response()->json($output, $code);
    }

    public function login()
    {
        $credentials = request(['email', 'password']);

        if (! $token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }
}
