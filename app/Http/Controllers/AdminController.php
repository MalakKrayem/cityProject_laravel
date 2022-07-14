<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Symfony\Component\HttpFoundation\Response;

class AdminController extends Controller
{

    public function __construct()
    {
        $this->authorizeResource(Admin::class, "admin");
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $admins = Admin::all();
        return response()->view("cms.admins.index", compact("admins"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::where("guard_name", "=", "admin")->get();
        return response()->view("cms.admins.create", compact("roles"));
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
            "email" => "required|unique:admins,email|email",
            "password" => "required|min:8|max:12",
            "role_id" => "required|numeric|exists:roles,id",

        ];
        $validator = Validator($request->all(), $rules);
        if (!$validator->fails()) {
            $admin = new Admin();
            $admin->name = $request->input('name');
            $admin->email = $request->input('email');
            $admin->password = Hash::make($request->input("password"));
            $isSaved = $admin->save();
            if ($isSaved) {
                $admin->assignRole(Role::findById($request->input("role_id"), "admin"));
            }
            return response()->json(
                ["message" => $isSaved ? "The admin saved Successfuly!" : "The admin saved faild!"],
                $isSaved ? Response::HTTP_CREATED : Response::HTTP_BAD_REQUEST
            );
        } else {
            return response()->json(["message" => $validator->getMessageBag()->first()], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function show(Admin $admin)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function edit(Admin $admin)
    {
        $roles = Role::where("guard_name", "=", "admin")->get();
        $adminRole = $admin->roles()->first();
        return response()->view("cms.admins.edit", compact("admin", "roles", "adminRole"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Admin $admin)
    {
        $rules = [
            "name" => "required|string|min:3|max:50",
            "email" => "required|email|unique:admins,email," . $admin->id,
            "role_id" => "required|numeric|exists:roles,id",

        ];
        $validator = Validator($request->all(), $rules);
        if (!$validator->fails()) {
            $admin->name = $request->input('name');
            $admin->email = $request->input('email');
            $isUpdated = $admin->save();
            if ($isUpdated) {
                $admin->syncRoles(Role::findById($request->input("role_id"), "admin"));
            }
            return response()->json(
                ["message" => $isUpdated ? "The admin updated Successfuly!" : "The admin updated faild!"],
                $isUpdated ? Response::HTTP_CREATED : Response::HTTP_BAD_REQUEST
            );
        } else {
            return response()->json(["message" => $validator->getMessageBag()->first()], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function destroy(Admin $admin)
    {
        $isDeleted = $admin->delete();
        return response()->json(
            ["message" => $isDeleted ? "Deleted successfuly!" : "Deleted faild!"],
            $isDeleted ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST
        );
    }
}
