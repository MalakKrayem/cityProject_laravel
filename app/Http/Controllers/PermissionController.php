<?php

namespace App\Http\Controllers;

//use App\Models\Permission;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Symfony\Component\HttpFoundation\Response;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $permissions = Permission::all();
        return response()->view("cms.permissions.index", compact("permissions"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return response()->view("cms.permissions.create");
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator($request->all(), [
            "guard_name" => "required|string|in:admin,web",
            "name" => "required|string"
        ]);

        if (!$validator->fails()) {
            $permission=new Permission();
            $permission->name = $request->input('name');
            $permission->guard_name = $request->input('guard_name');
            $isSaved = $permission->save();
            return response()->json(
                ["message" => $isSaved ? "The permission saved Successfuly!" : "The permission saved faild!"],
                $isSaved ? Response::HTTP_CREATED : Response::HTTP_BAD_REQUEST
            );
        } else {
            return response()->json(["message" => $validator->getMessageBag()->first()], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function show(Permission $permission)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function edit(Permission $permission)
    {
        return response()->view("cms.permissions.edit", compact("permission"));
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Permission $permission)
    {
        $validator = Validator($request->all(), [
            "guard_name" => "required|string|in:admin,web",
            "name" => "required|string"
        ]);

        if (!$validator->fails()) {
            $permission->name = $request->input('name');
            $permission->guard_name = $request->input('guard_name');
            $isupdated = $permission->save();
            return response()->json(
                ["message" => $isupdated ? "The permission updated Successfuly!" : "The permission updated faild!"],
                $isupdated ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST
            );
        } else {
            return response()->json(["message" => $validator->getMessageBag()->first()], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function destroy(Permission $permission)
    {
        $isDeleted = $permission->delete();
        return response()->json(
            ["message" => $isDeleted ? "Deleted successfuly!" : "Deleted faild!"],
            $isDeleted ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST
        );
    }
}
