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
}
