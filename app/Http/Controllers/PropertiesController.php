<?php

namespace App\Http\Controllers;

use App\Models\Property;
use Illuminate\Http\Request;


class PropertiesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $properties = Property::all();
        return view("properties.index", compact("properties"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view("properties.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'required|string',
            'location' => 'required|string|max:255',
            'price' => 'required|numeric',
            'status' => 'required|in:unavailable,reserved,available,rent',
        ]);
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('user_images', 'public');
            $validatedData['image'] = $imagePath;
        }
        Property::create([ 'title' => $request->input('title'),
        'description' => $request->input('description'),
        'image' => $imagePath, 
        'location' => $request->input('location'),
        'price' => $request->input('price'),
        'status' => $request->input('status'),
]);
        return redirect()->route('properties.index')->with('success', 'Property created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Property $property)
    {
    return view('properties.show', compact('property'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Property $property)
    {
        //
        return view('properties.edit', compact('property'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,$id)
    {
        //
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'required|string',
            'location' => 'required|string|max:255',
            'price' => 'required|numeric',
            'status' => 'required|in:unavailable,reserved,available,rent',
        ]);

        $property = Property::findOrFail($id);
        $property->update($request->all());

        return redirect()->route('properties.index')->with('success', 'Property updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Property $property)
    {
        //
        $property = Property::findOrFail($property->all());
        $property->delete();

        return redirect()->route('properties.index')->with('success', 'Property deleted successfully.');
    }
} 