<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Api_Utils;
use App\Models\Person;
use App\Models\User;
use Illuminate\Http\Request;

class PWDCountController extends Controller
{
    //
    public static function countPWD(Request $request)
    {
        try {
            // Count all pwds
            $pwdCount = Person::count();

            return Api_Utils::success($pwdCount, "Count of person with disabilities", 200);
        } catch (\Exception $e) {
            return Api_Utils::error($e->getMessage(), 400);
        }
    }
}
