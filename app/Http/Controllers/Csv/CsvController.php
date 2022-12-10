<?php

namespace App\Http\Controllers\Csv;

use App\Http\Controllers\Controller;
use App\Jobs\ProcessCsv;


class CsvController extends Controller
{    
    public function get_csv()
    {
        ProcessCsv::dispatch();
        return response()->json(['message' => 'Successful'], 200);
    }
}
