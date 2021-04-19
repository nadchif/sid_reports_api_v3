<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\Union;

class UnionController extends Controller
{
    public function index(Request $request)
    {
        $data = Union::get();
        return response()->json(
            [
                'data' => $data
            ],
            200
        );
    }
    public function get(Request $request, $id)
    {
        $data = Union::find($id);
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
