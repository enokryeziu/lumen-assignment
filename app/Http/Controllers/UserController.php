<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login']]);
    }

    public function index() {
        return 'Welcome ' . auth()->user()->name;
    }

    public function register(Request $request){
        $this->validate($request, [
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed'
        ]);

        try {

            $user = new User;

            $user->name = $request->input('name');
            $user->email = $request->input('email');

            $password = $request->input('password');
            $user->password = app('hash')->make($password);

            $user->save();

            $code = 200;
            $output = [
                'user' => $user,
                'code' => $code,
                'message' => 'User created successfully'
            ];



        } catch (Exception $th) {
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
