<?php

namespace App\Http\Controllers;

use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PropertiesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $properties = Property::all();
        return view("properties.index", compact("properties"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("properties.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'location' => 'required|string|max:255',
            'price' => 'required|numeric',
            'status' => 'required|in:unavailable,reserved,available,rent',
        ]);

        // Handle the image upload
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('properties_images', 'public');
            $validatedData['image'] = $imagePath;
        }

        // Create the property
        Property::create($validatedData);

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
        return view('properties.edit', compact('property'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Property $property)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'location' => 'required|string|max:255',
            'price' => 'required|numeric',
            'status' => 'required|in:unavailable,reserved,available,rent',
        ]);

        // Handle the image update
        if ($request->hasFile('image')) {
            // Delete the old image
            if ($property->image) {
                Storage::disk('public')->delete($property->image);
            }

            // Store the new image
            $imagePath = $request->file('image')->store('properties_images', 'public');
            $validatedData['image'] = $imagePath;
        }

        // Update the property
        $property->update($validatedData);

        return redirect()->route('properties.index')->with('success', 'Property updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Property $property)
    {
        // Delete the image if it exists
        if ($property->image) {
            Storage::disk('public')->delete($property->image);
        }

        // Delete the property
        $property->delete();

        return redirect()->route('properties.index')->with('success', 'Property deleted successfully.');
    }
}
