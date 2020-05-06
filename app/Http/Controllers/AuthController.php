<?php

namespace App\Http\Controllers;

use App\Http\Resources\ResponseResource;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required',
            'password' => 'required'
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return (new ResponseResource($user, 'Username tidak ada'))
                ->response()
                ->setStatusCode(401);
        }

        if (!Hash::check($request->password, $user->password)) {
            return (new ResponseResource(null, 'Password salah'))
                ->response()
                ->setStatusCode(401);
        }

        $user->api_token = base64_encode(Str::random(32));
        $user->save();
        return (new ResponseResource($user, 'Berhasil'));
    }
}
