<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\DBTransactions\SaveEmployee;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\EmployeeRequestValidation;

class AuthController extends Controller
{
    /**
     * User registration.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(EmployeeRequestValidation $request)
    {
        try {
            $saveEmployee = new SaveEmployee($request);
            $saveEmployee = $saveEmployee->executeProcess();
            if ($saveEmployee) {
                return response()->json(['status' => 'OK', 'message' => 'Employee registered successfully'], 201);
            } else {
                return response()->json(['status' => 'NG', 'message' => 'Failed to create employee.'], 200);
            }
        } catch (\Exception $e) {
            Log::debug($e->getMessage() . 'in file ' . __FILE__ . ' on line ' . __LINE__);
            return response()->json(['status' => 'NG', 'message' => 'Internal server error! Please contact with developer.'], 500);
        }
    }

    /**
     * User login.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        // Validate user input
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'NG', 'message' => $validator->errors()], 400);
        }

        // Attempt to authenticate the user
        if (Auth::attempt(['email' => $request->input('email'), 'password' => $request->input('password')])) {
            $user = Auth::user();
            $token = $user->createToken('MyApp')->accessToken;

            return response()->json(['status' => 'OK', 'token' => $token], 200);
        }
        return response()->json(['status' => 'NG', 'message' => 'Unauthorized'], 401);
    }

    /**
     * Get the authenticated user.
     *
     * @return \Illuminate\Http\Response
     */
    public function user()
    {
        return response()->json(['status' => 'OK', 'user' => Auth::user()], 200);
    }

    /**
     * User logout.
     *
     * @return \Illuminate\Http\Response
     */
    public function logout()
    {
        Auth::user()->token()->revoke();

        return response()->json(['status' => 'OK', 'message' => 'User logged out successfully'], 200);
    }
}
