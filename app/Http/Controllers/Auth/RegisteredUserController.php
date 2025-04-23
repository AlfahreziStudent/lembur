<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Auth\Events\Registered;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {

        return view('auth.register');
    }


    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email:rfc,dns', 'max:255', 'unique:'.User::class],
            'status' => ['required', 'string', 'max:255'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

            $data['name'] = $request->name;
            $data['email'] = $request->email;
            $data['status'] = $request->status;
            $data['password'] = Hash::make($request->password);

        $user = User::create($data);
        event(new Registered($user));
        $user->sendEmailVerificationNotification();

        Auth::login($user);
        return redirect(RouteServiceProvider::HOME);
    }
}
