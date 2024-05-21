<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Player;
use App\Http\Controllers\API\BaseController as BaseController;
use Dotenv\Validator;
use Illuminate\Http\JsonResponse;

class PlayerController extends Controller
{
    public function index(): JsonResponse
    {
        $player = Player::all();

        return response()->json(['message' => 'Player retrieved successfully', 'data' => $player], 200);
    }
}
