<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class TestController extends Controller
{
    public function roles()
    {
        return response()->json(
            DB::table('roles')->get()
        );
    }
}
