<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Storage;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $users = User::all();
        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the input
        $validatedData = $request->validate([
            'fullname' => 'required|max:255',
            'email' => 'required|email|unique:users',
            'age' => 'required|numeric|min:18',
            'password' => 'required|min:8',
            'phone' => 'required|digits:11',
            'role' => 'required|string',
            'id_identify' => 'required|digits:14',
            'id_identify_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ], [
            'phone.digits' => 'The phone number must be exactly 11 digits.',
            'id_identify.digits' => 'The ID number must be exactly 14 digits.',
        ]);

        // Handle file uploads
        if ($request->hasFile('id_identify_image')) {
            $idIdentifyImagePath = $request->file('id_identify_image')->store('id_identify_images', 'public');
            $validatedData['id_identify_image'] = $idIdentifyImagePath;
        }

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('user_images', 'public');
            $validatedData['image'] = $imagePath;
        }

        // Hash the password
        $validatedData['password'] = bcrypt($validatedData['password']);

        // Create the user
        User::create($validatedData);

        // Redirect with success message
        return to_route('users.create')->with('success', 'User created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        return view('users.show', ['user' => User::findOrFail($id)]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        // Validate the request
        $validatedData = $request->validate([
            'id_identify' => 'required|string|size:14|unique:users,id_identify,' . $user->id,
            'id_identify_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'fullname' => 'required|string|max:255|unique:users,fullname,' . $user->id,
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8',
            'age' => 'required|integer|min:18',
            'phone' => 'required|string|size:11|unique:users,phone,' . $user->id,
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'role' => 'required|in:landlord,tenant',
        ]);

        // Handle file uploads
        if ($request->hasFile('id_identify_image')) {
            // Delete the old image if it exists
            if ($user->id_identify_image) {
                Storage::disk('public')->delete($user->id_identify_image);
            }
            $validatedData['id_identify_image'] = $request->file('id_identify_image')->store('id_identify_images', 'public');
        }

        if ($request->hasFile('image')) {
            // Delete the old image if it exists
            if ($user->image) {
                Storage::disk('public')->delete($user->image);
            }
            $validatedData['image'] = $request->file('image')->store('user_images', 'public');
        }

        // Hash the password if provided
        if ($request->filled('password')) {
            $validatedData['password'] = bcrypt($validatedData['password']);
        } else {
            unset($validatedData['password']);
        }

        // Update the user
        $user->update($validatedData);

        return to_route('users.index')->with('success', 'User updated successfully!');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        // Delete associated files
        if ($user->id_identify_image) {
            Storage::disk('public')->delete($user->id_identify_image);
        }
        if ($user->image) {
            Storage::disk('public')->delete($user->image);
        }

        // Delete the user
        $user->delete();

        return redirect()->route('users.index')->with('success', 'User deleted successfully!');
    }
}
