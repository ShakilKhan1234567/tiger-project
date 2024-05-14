<?php

namespace App\Http\Controllers;

use App\Models\Loginfo;
use Illuminate\Http\Request;

class LogController extends Controller
{

    function log_info(){
        $logs = Loginfo::all();
        return view('admin.log.log_info',[
            'logs'=>$logs,
        ]);
    }
}
