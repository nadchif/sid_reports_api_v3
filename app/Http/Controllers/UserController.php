<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use \App\Models\User;
use \App\Models\Union;
use \App\Models\Conference;
use \App\Models\District;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index()
    {
        $currentUser = Auth::user();
        $data = null;
        switch ($currentUser->category) {
            case 'admin':
                $data = User::get();
                break;
            case 'union':
                $data = Union::find($currentUser->org_id)->allUsers;
                break;
            break;
        }

        $response_data = [
            'data' => $data != null ? $data : null
        ];
        if ($data == null) {
            $response_data['error'] = 'Could not find requested entry';
        }
        return response()->json(
            $response_data,
            $data == null ? 404 : 200,
        );
    }
}
