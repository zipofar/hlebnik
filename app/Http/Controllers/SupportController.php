<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SupportController extends Controller
{
    private function hasMatch($str, $needle)
    {
        $needles = explode(" ", $needle);
        $filteredNeedles = array_filter($needles, function ($e) use ($str) {
            return stripos($str, $e) !== false;
        });

        return count($filteredNeedles) > 0;
    }

    private function findAnswer($question, $solutions)
    {
        $themeNames = array_keys($solutions);

        return array_reduce($themeNames, function ($acc, $themeName) use ($question, $solutions) {
            $theme = $solutions[$themeName];

            $filteredThemeSolutions = array_filter($theme, function ($themeItem) use ($question) {
                return $this->hasMatch($themeItem['symptom'], $question);
            });

            if (count($filteredThemeSolutions) > 0) {
                $acc[$themeName] = $filteredThemeSolutions;
            }
            return $acc;
        }, []);
    }

    public function index(Request $request)
    {
        $inputSearch = $request->input('search'); 
        $rawSampleData = file_get_contents('../database/sample-data.json');
        $solutions = json_decode($rawSampleData, true);
        $answers = $this->findAnswer($inputSearch, $solutions);
        return view('support', ['answers' => $answers, 'question' => $inputSearch]);
    }
}
