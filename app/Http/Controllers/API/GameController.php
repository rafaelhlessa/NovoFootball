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
                $matches['Divisão ' . $division][] = $matchResult;
            }
        }

        return response()->json($matches);
    }

    private function simulateMatch($homeTeam, $awayTeam)
    {
        // $homeDivision = $homeTeam->championship_id;
        // $awayDivision = $awayTeam->championship_id;

        // $homeDivisionTeams = Team::where('championship_id', $homeDivision)->get();
        // $awayDivisionTeams = Team::where('championship_id', $awayDivision)->get();

        // $homeStrength = $this->calculateTeamStrength($homeTeam);
        // $awayStrength = $this->calculateTeamStrength($awayTeam);
        // // Implementar lógica de simulação de eventos
        // $events = $this->simulateEvents($homeStrength, $awayStrength);
        // $audience = $this->calculateAudience($homeTeam);

        // $match = [
        //     'home_team' => $homeTeam->name,
        //     'away_team' => $awayTeam->name,
        //     'game_division' => $homeDivision,
        //     'events' => $events,
        //     'audience' => $audience,
        // ];


        // // Adicione o jogo ao array de jogos separado por divisão
        // $divisionMatches[$homeDivision][] = $match;
        // $divisionMatches[$awayDivision][] = $match;

        // return $match;

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

    public function simulateGoals(Request $request)
    {
        $homeTeam = [true, false, true, false, true];
        $awayTeam = [false, true, false, true, false];

        $homeGoals = 0;
        $awayGoals = 0;

        for ($i = 1; $i <= 20; $i++) {
            if ($homeTeam[$i % count($homeTeam)] === true) {
                $homeGoals++;
            }
            if ($awayTeam[$i % count($awayTeam)] === true) {
                $awayGoals++;
            }
            sleep(1);
            // Pode retornar os gols a cada iteração, se necessário
            // return response()->json([
            //     'home_goals' => $homeGoals,
            //     'away_goals' => $awayGoals,
            // ]);
        }

        // Fora do loop, após 20 segundos, retorna os gols
        return response()->json([
            'home_goals' => $homeGoals,
            'away_goals' => $awayGoals,
        ]);
    }


    private function simulateEvents($homeStrength, $awayStrength)
    {
        $homeTeam = [1, 2, 3, 4, 5, 6];
        $awayTeam = [1, 2, 3, 4, 5, 6];

        $homeGoals = 0;
        $awayGoals = 0;

        foreach ($homeTeam as $key => $value) {
            if (mt_rand(0, 3) === 3) {
                $homeGoals++;
            }
            // if ($homeTeam[$key] === true) {
            //     $homeGoals++;
            // }
        }

        foreach ($awayTeam as $key => $value) {
            if (mt_rand(0, 2) === 2) {
                $awayGoals++;
            }
        }


//        implementar a lógica de simulação de eventos distribuindo os valores entre os times
        $events = [
            'home_goals' => $homeGoals,
            'away_goals' => $awayGoals,
            // 'red_cards_home' => rand(0, 1),
            // 'red_cards_away' => rand(0, 1),
            // 'injuries_home' => rand(0, 1),
            // 'injuries_away' => rand(0, 1),
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
