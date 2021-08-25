<?php

namespace App\Http\Traits;
use Illuminate\Support\Facades\Auth;

trait VerifyRoles {
    public function isAdmin()
    {
        $category = Auth::user()->category;
        if (strtolower($category) !== 'admin') {
            return response()->json(array(
                'error' => 'Restricted to admins',
                'error_info'=> $category
            ), 403);
        }
        return true;
    }
}