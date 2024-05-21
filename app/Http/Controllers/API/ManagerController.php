<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Manager;

class ManagerController extends Controller
{
    public function index()
    {
        $manager = Manager::all();

        return response()->json(['message' => 'Manager retrieved successfully', 'data' => $manager], 200);
    }

    public function store(Request $request)
    {
        dd($request);
        // Validate incoming data
        $request->validate([
            'name' => 'required|string|max:255',
            // Add more validation rules as needed
        ]);

        // Create a new manager instance
//        $manager = new Manager();
//        $manager->name = $request->name;
//        // Set other attributes as needed
//
//        // Save the manager into the database
//        $manager->save();
//
//        // Return a response indicating success
//        return response()->json(['message' => 'Manager created successfully', 'manager' => $manager], 201);
    }
}
