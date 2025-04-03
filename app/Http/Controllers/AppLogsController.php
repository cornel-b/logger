<?php

namespace App\Http\Controllers;

use App\Models\AppLog;

class AppLogsController extends Controller
{
    public function showLogs()
    {

        $logs = AppLog::orderBy('created_at', 'desc')->paginate(20);

        return view('app_logs.index', compact('logs'));
    }
}
