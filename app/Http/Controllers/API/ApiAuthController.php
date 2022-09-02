<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;

class ApiAuthController extends Controller
{
    public function loginPersonal(Request $request)
    {
        $validator = Validator($request->all(), [
            "email" => "required|email|exists:users,email",
            "password" => "required|string|min:8|max:12"
        ]);

        if (!$validator->fails()) {
            $user = User::where("email", $request->input("email"))->first();
            if (Hash::check($request->input("password"), $user->password)) {
                $this->revokePreviousTokens($user->id);
                $token = $user->createToken("User");
                $user->setAttribute("token", $token->accessToken);
                //I change the expire time in AuthServiceProvider in boot method
                return response()->json(["message" => "Logged successfully!", "data" => $user], Response::HTTP_OK);
            } else {
                return response()->json(["message" => "Login faild, wrong password!"], Response::HTTP_BAD_REQUEST);
            }
        } else {
            return response()->json(["message" => $validator->getMessageBag()->first()], Response::HTTP_BAD_REQUEST);
        }
    }

    public function loginPGCT(Request $request)
    {
        // I change the expire time for  it in AuthServiceProvider using expireIn function
        $validator = Validator($request->all(), [
            "email" => "required|email|exists:users,email",
            "password" => "required|string|min:8|max:12"
        ]);

        if (!$validator->fails()) {
            //$user = User::where("email", $request->input("email"))->first();
            //$this->revokePreviousTokens($user->id);
            return $this->generatePgctToken($request);
        } else {
            return response()->json(["message" => $validator->getMessageBag()->first()], Response::HTTP_BAD_REQUEST);
        }
    }

    private function generatePgctToken(Request $request)
    {
        //I add line in AuthServiceProvider for passport route
        //I got this data from oauth_clients table
        try {
            // php artisan serve --port=81
            $response = Http::asForm()->post("http://127.0.0.1:81/oauth/token", [
                "grant_type" => "password",
                "client_id" => "2",
                "client_secret" => "TWQMddbPtj1XXOdABMyUIdvaTITJi8mCt2WSshsU",
                //I add findForPassport mehtod in User modle to deliver "username" from here
                "username" => $request->input("email"), //Will search in users table in email column
                // I add method to check password  in User model
                "password" => $request->input("password"),
                "scope" => "*"  //That's mean all
            ]);
            $user = User::where("email", $request->input("email"))->first();
            //$this->revokePreviousTokens($user->id, 2);
            $user->setAttribute("token", $response->json()["access_token"]);
            return response()->json(["message" => "Logged in successfully!", "data" => $user], Response::HTTP_OK);
            //return $response;
        } catch (Exception $ex) {
            //return $response;
            return response()->json(["message" => $response()->json()["message"]], Response::HTTP_BAD_REQUEST);
        }
    }

    private function revokePreviousTokens($userId, $clientId = 1)
    {
        DB::table("oauth_access_tokens")->where("user_id", "=", $userId)->where("client_id", "=", $clientId)->update(["revoked" => true]);
    }

    public function logout()
    {
        $revoked = auth("user-api")->user()->token()->revoke();
        return response()->json(
            [
                "message" => $revoked ? "Logout Successfuly!" : "Logout Faild"
            ],
            $revoked ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST
        );
        // I add [accept : application/json] && [Authorization : Bearer {{TOKEN}}] header in postman for this request
        // It return 401 unauthorized because of accept in the header that we tell him to return json
    }
}
