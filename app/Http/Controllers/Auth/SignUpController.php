<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\SignUpRequest;
use Illuminate\Http\Request;
use App\Models\User;
use Auth;

class SignUpController extends Controller
{
    public function show() {
        return view('pages.auth.sign-up');
    }

    public function signUp(SignUpRequest $request) {
        // Dapatkan Request Dari Form Request
        $validated = $request->validated();
        
        // Tambahkan Password Dengan Method Bcrypt (Hash)
        $validated['password'] = bcrypt($validated['password']);

        // Tambahkan Picture Dummy Sesuai Dengan Username
        $validated['picture'] = config('app.avatar_generator_url').$validated['username'];
        
        // Create User Berdasarkan Request Yang Valid
        $create = User::create($validated);

        // Jika Create Berhasil Maka Loginkan User, Redirect ke List Discussions
        if ($create) {
            Auth::login($create);
            return redirect()->route('discussions.index');
        }

        // Jika Create Tidak Berhasil Maka Return 500
        return abort(500);
    }
}
