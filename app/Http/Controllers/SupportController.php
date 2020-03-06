<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SupportController extends Controller
{
    public function index(Request $request)
    {
        $rawSampleData = file_get_contents('../database/sample-data.json');
        $sampleData = json_decode($rawSampleData, true);
        var_dump($sampleData);
        $inputSearch = $request->input('search'); 
        return view('support');
    }
}
