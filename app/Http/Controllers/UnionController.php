<?php

namespace App\Http\Controllers;

use App\Http\Traits\VerifyRoles;
use Illuminate\Http\Request;
use \App\Models\Union;

class UnionController extends Controller
{
    use VerifyRoles;

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
    public function post(Request $request)
    {
        $isAdmin = $this->isAdmin();
        if($isAdmin !== true){
            return $isAdmin;
        };
        $request->validate([
            'name' => 'required|min:2|string',
            'code' => 'required|min:2|string',
            'address'=> 'required|min:6|string',
            'phone'=> 'required|digits',
        ]);
        $user = Union::create([
            'email'=>$request->email,
            'password' => $request->password,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'category' => $request->category,
            'org_id' => $request->org_id,
        ]);
        return response()->json($user, 500);



    }

}
