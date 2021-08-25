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
                $data = Union::find($currentUser->org_id)->allUsers();
                break;
            case 'conference':
                $data = Conference::find($currentUser->org_id)->allUsers();
                break;
            case 'district':
                $data = District::find($currentUser->org_id)->allUsers();
                break;
            case 'church':
                $data = [User::find($currentUser->id)];
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

    public function get($id)
    {
        $currentUser = Auth::user();
        $data = null;
        if (in_array($currentUser->category, ['admin', 'union', 'conference'])) {
            $data = User::find($id);
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

    public function put(Request $request, $id)
    {
        $currentUser = Auth::user();
        return response()->json(['error' => 'wip'], 503);
        $request->validate([
            'email' => 'required_without:token|string',
            'password' => 'required_without:token|string',
            'token' => 'required_without:password|string|min:8',
        ]);
    }

    public function post(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6|string',
            'first_name' => 'required|min:2|string',
            'last_name' => 'required|min:2|string',
            'category' => 'required|in:admin,union,conference,district,church',
            'org_id' => 'required|int',
        ]);

        DB::beginTransaction();
        try {
            $user = User::create([
                'email' => $request->email,
                'password' => $request->password,
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'category' => $request->category,
                'org_id' => $request->org_id,
            ]);
            $user->sendEmailVerificationNotification();
            DB::commit();
            return response()->json(array(
                'data' => $user,
                'errors' => null,
            ), 201);
        } catch (\Exception $e) {
            DB::rollBack();
            $code = $e->getCode();
            return response()->json(array(
                'data' => null,
                'error' => $code == 23000 ? 'Cannot use email/username. Try another' : $e->getMessage(),

            ), $code == 23000 ? 409 : 500);
        }
    }
}
