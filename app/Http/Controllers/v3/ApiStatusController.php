<?php

namespace App\Http\Controllers\v3;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ApiStatusController extends Controller
{
     //
     public function status (Request $request) {
        return response()->json(array(
            'status' => 'API is running!',
            'version' => '3.0.0',
            'time'=> date('Y-m-d H:i:s')
        ), 200);
    }

    public function fallback(Request $request){
            return response()->json([
                'message' => 'Path not found. If error persists, contact the administrator'], 404);
    }

}
