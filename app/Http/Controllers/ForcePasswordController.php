<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ForcePasswordController extends Controller
{
    /**
     * Show the forced password change form.
     */
    public function create()
    {
        return view('auth.force-password-change');
    }

    /**
     * Update the user's password and remove the force flag.
     */
    public function store(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        $user = $request->user();

        $user->update([
            'password' => Hash::make($request->password),
            'must_change_password' => false,
        ]);

        return redirect()->route('dashboard')->with('status', 'password-updated');
    }
}
