<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function showLogin($guard)
    {
        return response()->view("cms.auth.login", ["guard" => $guard]);
        //$request->request->add(["guard"=>$request->guard]);

        // $data = ["guard" => $request->guard];
        // $validator = Validator($data, [
        //     "guard" => "required|string|in:admin,web"
        // ]);
        // if (!$validator->fails()) {
        //     return response()->view("cms.auth.login", ["guard" => $request->guard]);
        // } else {
        //     abort(Response::HTTP_NOT_FOUND);
        // }
    }

    public function login(Request $request)
    {
        $table = $request->guard == "web" ? "users" : "admins";
        $validator = Validator($request->all(), [
            "email" => "required|email",
            "password" => "required|string|min:3",
            "remember" => "required|boolean",
            "guard" => "required|string|in:admin,web"
        ]);

        if (!$validator->fails()) {
            $crendentials = ["email" => $request->input("email"), "password" => $request->input("password")];
            if (Auth::guard($request->input("guard"))->attempt($crendentials, $request->input("remember"))) {
                return response()->json(["message" => "Login successfuly!"], Response::HTTP_OK);
            } else {
                return response()->json(["message" => "Login faild!, Check your crendentials. "], Response::HTTP_BAD_REQUEST);
            }
        } else {
            return response()->json(["message" => $validator->getMessageBag()->first()], Response::HTTP_BAD_REQUEST);
        }
    }

    public function logout(Request $request)
    {
        $guard = auth("web")->check() ? "web" : "admin";
        Auth::guard($guard)->logout();
        $request->session()->invalidate();
        return redirect()->route("login", $guard);
    }
}
