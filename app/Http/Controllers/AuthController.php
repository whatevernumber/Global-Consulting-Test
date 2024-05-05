<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginFormRequest;
use App\Http\Requests\RegistrationFormRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;

class AuthController extends Controller
{

    public function register(RegistrationFormRequest $request): RedirectResponse
    {
        $formData = $request->validated();
        $formData['password'] = Hash::make($formData['password']);
        User::create($formData);

        return to_route('login.page');
    }

    public function login(LoginFormRequest $request): RedirectResponse
    {
        if (Auth::attempt($request->validated())) {
            $request->session()->regenerate();

            return to_route('products.all');
        }

        return to_route('login.page')->withErrors(['password' => 'Пароль не совпадает']);
    }

    public function logout(): RedirectResponse
    {
        Auth::logout();

        return to_route('login');
    }
}
