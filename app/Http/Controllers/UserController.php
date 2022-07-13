<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::with("city")->get();
        return response()->view("cms.users.index", compact("users"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $cities = City::where("active", "=", true)->get();
        return response()->view("cms.users.create", compact("cities"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            "name" => "required|string|min:3|max:50",
            "email" => "required|unique:users,email|email",
            "city_id" => "required|numeric|exists:cities,id",
            "password" => "required|min:8|max:12"
        ];
        $validator = Validator($request->all(), $rules);
        if (!$validator->fails()) {
            $user = new User();
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->city_id = $request->input('city_id');
            $user->password = Hash::make($request->input("password"));
            $isSaved = $user->save();
            return response()->json(
                ["message" => $isSaved ? "The user saved Successfuly!" : "The user saved faild!"],
                $isSaved ? Response::HTTP_CREATED : Response::HTTP_BAD_REQUEST
            );
        } else {
            return response()->json(["message" => $validator->getMessageBag()->first()], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $cities = City::where("active", "=", true)->get();
        return response()->view("cms.users.edit", compact("cities", "user"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $rules = [
            "name" => "required|string|min:3|max:50",
            "email" => "required|email|unique:users,email," . $user->id,
            "city_id" => "required|numeric|exists:cities,id",
        ];
        $validator = Validator($request->all(), $rules);
        if (!$validator->fails()) {
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->city_id = $request->input('city_id');
            $isUpdate = $user->save();
            return response()->json(
                ["message" => $isUpdate ? "The user updated Successfuly!" : "The user updated faild!"],
                $isUpdate ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST
            );
        } else {
            return response()->json(["message" => $validator->getMessageBag()->first()], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $isDeleted = $user->delete();
        return response()->json(
            ["message" => $isDeleted ? "Deleted successfuly!" : "Deleted faild!"],
            $isDeleted ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST
        );
    }
}
