<?php

namespace App\Http\Controllers;

use App\Models\LoginLog;

class LoginLogController extends Controller
{
    public function store(int $id)
    {
        LoginLog::create([
            'user_id' => $id,
        ]);
    }
}
