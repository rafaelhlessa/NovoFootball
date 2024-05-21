<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Championship;
use App\Http\Controllers\API\BaseController as BaseController;
use Dotenv\Validator;
use Illuminate\Http\JsonResponse;

class ChampionshipController extends Controller
{
    public function index(): JsonResponse
    {
        $championship = Championship::all();

        return response()->json(['message' => 'Championship retrieved successfully', 'data' => $championship], 200);
    }
}
