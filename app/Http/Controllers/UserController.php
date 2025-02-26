<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;


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
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
