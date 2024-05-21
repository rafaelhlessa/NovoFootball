<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Manager;

class ManagerController extends Controller
{
    public function store(Request $request)
    {
        dd($request);
        $manager = new Manager();
        $manager->name = $request->input('name');
        $manager->save();

        return response()->json(['message' => 'Manager saved successfully'], 201);
    }
}
