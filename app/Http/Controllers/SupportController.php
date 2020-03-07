<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SupportController extends Controller
{
    private function getSolutions()
    {
        $pathToSampleData = join('/', [__DIR__, '..', '..', '..', 'database', 'sample-data.json' ]);
        $rawSampleData = file_get_contents($pathToSampleData);
        return json_decode($rawSampleData, true);
    }

    private function buildQuestion($question)
    {
        $needles = explode(" ", $question);
        return array_map(function ($e) {
            return [
                'length' => mb_strlen($e),
                'needle' => $e
            ];
        }, $needles);
    }

    private function getOccurances($symptom, $questionNeedles)
    {
        $needlesWithOccurances = array_map(function($needle) use ($symptom) {
            $countOccurance = mb_substr_count($symptom, $needle['needle']);
            $needle['countOccurance'] = $countOccurance;
            $needle['lengthOccurance'] = $countOccurance * $needle['length'];
            return $needle;
        }, $questionNeedles);
        $needlesWithSumOccurances = array_reduce($needlesWithOccurances, function ($acc, $needle) {
            $acc['countOccurance'] += $needle['countOccurance']; 
            $acc['lengthOccurance'] += $needle['lengthOccurance']; 
            return $acc;
        }, ['countOccurance' => 0, 'lengthOccurance' => 0]);
        return $needlesWithSumOccurances;
    }

    private function findAnswer($question, $solutions)
    {
        $themeNames = array_keys($solutions);
        $questionNeedles = $this->buildQuestion($question);

        $flatSolutions = array_reduce($themeNames, function($acc, $themeName) use ($solutions) {
            $res = array_map(function($solution) use ($themeName) {
                $solution['theme'] = $themeName;
                return $solution;
            }, $solutions[$themeName]);
            return array_merge($acc, $res);
        }, []);
        
        $solutionsWithStatsOccurance = array_map(function($themeItem) use ($questionNeedles) {
            $symptom = $themeItem['symptom'];
            $infoOccurances = $this->getOccurances($symptom, $questionNeedles);
            return array_merge($themeItem, $infoOccurances);
        }, $flatSolutions);

        $filteredSolutions = array_filter($solutionsWithStatsOccurance, function ($solution) {
            return $solution['countOccurance'] !== 0;
        });

        usort($filteredSolutions, function ($a, $b) {
            if($a['countOccurance'] === $b['countOccurance']) {
                return $a['lengthOccurance'] < $b['lengthOccurance'] ? 1 : 0;
            }
            return $a['countOccurance'] < $b['countOccurance'] ? 1 : 0;
        });

        return $filteredSolutions;
    }

    public function index(Request $request)
    {
        $question = $request->input('search'); 
        if (!$question) {
            return view('support', ['answers' => [], 'question' => $question]);
        }
        $solutions = $this->getSolutions();
        $answers = $this->findAnswer($question, $solutions);
        return view('support', ['answers' => $answers, 'question' => $question]);
    }
}
