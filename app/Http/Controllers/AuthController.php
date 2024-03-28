<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Administrateur;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use LdapRecord\Container;

class AuthController extends Controller
{

    public function auth(Request $request) {

        $this->validate($request, [
            'name' => 'required|string',
            'password' => 'required|string',
        ]);

        if (Auth::attempt(['name' => $request->name, 'password' => $request->password])) {
            $user = Administrateur::where('name', $request['name'])->first();

            $token = $user->createToken('auth_token')->plainTextToken;
    
            return response()->json([
                'name' => $request['name'],
                'token' => $token,
                'token_type' => 'Bearer',
            ]);
        } else {
            return response()->json([
                'error' => 'error',
            ]);
        }
    }
}