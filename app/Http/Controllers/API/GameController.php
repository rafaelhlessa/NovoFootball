<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Team;
use App\Models\Player;

class GameController extends Controller
{
    public function processRound()
    {
        // Obtenha todas as divisões
        $divisions = ['1', '2', '3', '4'];
        $matches = [];

        foreach ($divisions as $division) {
            $teams = Team::where('championship_id', $division)->inRandomOrder()->take(8)->get();
//            $divisionMatches = $this->simulateDivision($teams, $division);
            // Assumindo que os times são pareados de forma sequencial para 4 jogos
            for ($i = 0; $i < 8; $i += 2) {
                $homeTeam = $teams[$i];
                $awayTeam = $teams[$i + 1];

                $matchResult = $this->simulateMatch($homeTeam, $awayTeam);
                array_push($matches, $matchResult);
            }
        }

        return response()->json($matches);
    }

    private function simulateMatch($homeTeam, $awayTeam)
    {
        $homeStrength = $this->calculateTeamStrength($homeTeam);
        $awayStrength = $this->calculateTeamStrength($awayTeam);

        // Implementar lógica de simulação de eventos
        $events = $this->simulateEvents($homeStrength, $awayStrength);

        $audience = $this->calculateAudience($homeTeam);


        return [

            'home_team' => $homeTeam->name,
            'away_team' => $awayTeam->name,
            'serie' => $homeTeam->championship_id,
            'events' => $events,
            'audience' => $audience,
        ];
    }

    private function calculateTeamStrength($team)
    {
        $players = Player::where('team_id', $team->id)->take(11)->get();
        $strength = $players->sum('strength') + $team->morale;

        return $strength;
    }

    private function simulateEvents($homeStrength, $awayStrength)
    {
        // Simule eventos baseados na força dos times e outros fatores
//        $events = [
//            'goals' => rand(0, 7),
//            'red_cards' => rand(0, 1),
//            'injuries' => rand(0, 1),
//            'penalties' => rand(0, 1),
//        ];

//        implementar a lógica de simulação de eventos distribuindo os valores entre os times
        $events = [
            'home_goals' => rand(0, 5),
            'away_goals' => rand(0, 4),
            'red_cards_home' => rand(0, 1),
            'red_cards_away' => rand(0, 1),
            'injuries_home' => rand(0, 1),
            'injuries_away' => rand(0, 1),
//            'penalties_home' => rand(0, 1),
//            'penalties_away' => rand(0, 1),

        ];

        return $events;
    }

    private function calculateAudience($homeTeam)
    {
        $moraleFactor = $homeTeam->morale / 100;
        $minAudience = 0.5 * $homeTeam->capacity;
        $audience = $minAudience + ($homeTeam->capacity - $minAudience) * $moraleFactor;

        return round($audience);
    }
}
