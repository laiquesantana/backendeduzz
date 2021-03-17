<?php

use Illuminate\Support\Facades\Auth;

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AccountController extends Controller
{
    /**
    * Create a new AccountController instance.
    *
    * @return void
    */
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index()
    {
        try {
            $user = auth()->userOrFail();
        } catch (\Tymon\JWTAuth\Exceptions\UserNotDefinedException $e) {
            // do something
        }

        return response()->json(['status' => 'success', 'operation' => $user->account->balance]);
    }

    public function store(Request $request)
    {
        try {
            $user = auth()->userOrFail();
        } catch (\Tymon\JWTAuth\Exceptions\UserNotDefinedException $e) {
            throw new Exception("User not found", 1);
        }


        $balance = $request->input('balance');

        //TODO create service to abstract this logic
        if (!empty(Account::where('user_id', $user->id)->first())) {
            throw new Exception("User already has an associated account", 1);
        }

        $this->validate($request, [
            'balance' => 'required|numeric',
        ]);

        Account::create(['user_id' => $user->id, 'balance' => $balance]);

        //TODO service to send email.
        return response()->json(['status' => 'success', 'operation' => 'created' ,'response' => $user->account]);
    }

    public function update(Request $request)
    {
        try {
            $user = auth()->userOrFail();
        } catch (\Tymon\JWTAuth\Exceptions\UserNotDefinedException $e) {
            throw new Exception("User not found", 1);
        }

        try {
            $balance = $request->input('balance');

            $this->validate($request, [
                'balance' => 'required|numeric',
            ]);

            $balance += $user->account->balance;

            $user->account->update(['balance' => $balance]);

            //TODO service to send email.
            return response()->json(['status' => 'success', 'operation' => 'updated' ,'response' => $user->account]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
