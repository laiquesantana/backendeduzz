<?php

use Illuminate\Support\Facades\Auth;

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\User;
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

        return $user->account;
    }

    public function store(Request $request)
    {
        try {
            $user = auth()->userOrFail();
        } catch (\Tymon\JWTAuth\Exceptions\UserNotDefinedException $e) {
            // do something
        }

        $balance = $request->input('balance');
        $balance += $user->account->balance;

        $user->account->update([
            'balance' => $balance,
        ]);

        return $user->account;
    }
}
