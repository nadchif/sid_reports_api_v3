<?php

namespace App\Http\Controllers;

use App\Models\Division;
use App\Models\Union;
use App\Models\Conference;
use App\Models\District;
use App\Models\Church;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class AuthController extends Controller
{
    public function login(Request $request)
    {
        $login = $request->validate([
            'email' => 'required_without:token|string',
            'password' => 'required_without:token|string',
            'token' => 'required_without:password|string|min:8',
        ]);

        if (isset($request->token)) {
            return $this->googleLogin($request->token);
        }

        $login_result = Auth::attempt(['email' => $request->email, 'password' => $request->password]);

        if (!$login_result) {
            return response()->json(array(
                'error' => 'invalid login credentials',
            ), 401);
        }

        $user = Auth::user();

        $user = Auth::user();
        if (is_null($user->email_verified_at)) {
            Auth::logout();
            return response()->json(array(
                'error' => 'Your user email is not yet verified',
            ), 401);
        }
        if ($user->blocked == 1) {
            Auth::logout();
            return response()->json(array(
                'error' => 'Your account requires a review by the System Adminstrator(s). This is normal if you have recently signed-up',
            ), 401);
        }

        $token = $user->createToken('authToken')->accessToken;

        return response()->json(array(
            'user' => $this->getStarterUserProfile($user),
            'access_token' => $token,
        ), 200);
    }
    private function getStarterUserProfile($user)
    {
        $org = null;
        switch ($user->category) {
            case 'admin':
                $org = Division::find($user->org_id);
                break;
            case 'union':
                $org = Union::find($user->org_id);
                break;
            case 'conference':
                $org = Conference::find($user->org_id);
                break;
            case 'district':
                $org = District::find($user->org_id);
                break;
            case 'church':
                $org = Church::find($user->org_id);
                break;
            default:
                $org = null;
        }

        return [
            'id' => $user->id,
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'category' => $user->category,
            'email' => $user->email,
            'org_data' => $org,
        ];
    }
    private function googleLogin($authToken)
    {
        // GOOGLE LOGIN
        if ((strlen($authToken) > 8)) {
            // fetch the basic info details
            $endpoint = 'https://www.googleapis.com/oauth2/v3/tokeninfo';
            $client = new \GuzzleHttp\Client();

            $response = $client->request('GET', $endpoint, [
                'query' => [
                    'id_token' => $authToken,
                ],
            ]);

            $statusCode = $response->getStatusCode();
            $resp = json_decode($response->getBody());

            // just a fall back for errors
            if (isset($resp->given_name)) {

                $firstName = $resp->given_name;
                $lastName = $resp->family_name;
                $email = $resp->email;
                $avatar = $resp->picture;

                $user_valid = DB::table('users')->where('email', $email)->first();

                if ($user_valid) {

                    Auth::loginUsingId($user_valid->id);

                    $user = Auth::user();
                    if (is_null($user->email_verified_at)) {
                        Auth::logout();
                        return response()->json(array(
                            'error' => 'Your user email is not yet verified',
                        ), 401);
                    }
                    if ($user->blocked == 1) {
                        Auth::logout();
                        return response()->json(array(
                            'error' => 'Your account requires a review by the System Adminstrator(s). This is normal if you have recently signed-up',
                        ), 401);
                    }

                    $token = $user->createToken('authToken')->accessToken;

                    return response()->json([
                        'user' => $this->getStarterUserProfile($user),
                        'access_token' => $token,
                    ], 200);
                } else {
                    return response()->json(array(
                        'error' => 'Cannot use Google to authenticate. Sign up first',
                    ), 401);
                }
            } else {
                return response()->json(array(
                    'error' => 'A server side error occured. Cannot use Google login right now.',
                ), 500);
            }
        } else {
            return response()->json(array(
                'error' => 'The token provided is too short',
            ), 401);
        }
    }
}
