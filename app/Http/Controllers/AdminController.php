<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Admin;
use Exception;

class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('assign.guard:users', ['except' => ['register','login']]);
    }

    public function index() {
        return 'Welcome admin';
    }

    public function register(Request $request){
        $this->validate($request, [
            'email' => 'required|email|unique:users',
            'password' => 'required',
        ]);

        try {

            $admin = new Admin;
            $admin->email = $request->input('email');
            $password = $request->input('password');
            $admin->password = app('hash')->make($password);
            $admin->save();



            $code = 200;
            $output = [
                'user' => $admin,
                'code' => $code,
                'message' => 'Admin created successfully'
            ];



        } catch (Exception $th) {
            return dd($th);
            $code = 500;
            $output = [
                'code' => $code,
                'message' => 'An error occured while creating admin.'
            ];
        }

        return response()->json($output, $code);
    }

    public function login()
    {
        $credentials = request(['email', 'password']);

        if (! $token = auth('admins')->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    public function logout()
    {
        auth('admins')->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }
}
