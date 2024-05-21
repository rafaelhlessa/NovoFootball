<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Team;
use App\Http\Controllers\API\BaseController as BaseController;
use Dotenv\Validator;
use Illuminate\Http\JsonResponse;

class TeamController extends Controller
{
    public function index(): JsonResponse
    {
        $team = Team::all();

        return response()->json(['message' => 'Team retrieved successfully', 'data' => $team], 200);
    }

    public function store(Request $request)
    {
        $manager = new Manager();
        $manager->name = $request->input('name');
        $manager->save();

        // Sorteie uma equipe com championship_id === 4
        $team = Team::where('championship_id', 4)->inRandomOrder()->first();
        if ($team) {
            $team->manager_id = $manager->id;
            $team->save();
        }

        return response()->json(['message' => 'Manager and team updated successfully'], 201);
    }

}
