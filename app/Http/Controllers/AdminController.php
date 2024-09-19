<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class AdminController extends Controller
{
    /**
     * Show the form for editing the admin's login details.
     */
    public function edit()
    {
        $admin = Auth::user(); // Get the currently authenticated admin
        return view('admin.settings', compact('admin'));
    }

    /**
     * Update the admin's login details.
     */
    public function update(Request $request)
    {
        $admin = Auth::user();

        // Validate the incoming request data
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $admin->id,
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        // Update the admin details
        $admin->name = $request->input('name');
        $admin->email = $request->input('email');

        if ($request->filled('password')) {
            $admin->password = Hash::make($request->input('password'));
        }

        $admin->save();

        return redirect()->route('admin.settings')->with('success', 'Admin details updated successfully.');
    }
}
