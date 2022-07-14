<?php

namespace App\Http\Controllers;

//use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Symfony\Component\HttpFoundation\Response;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Role::withCount("permissions")->get();
        return response()->view("cms.roles.index", compact("roles"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return response()->view("cms.roles.create");
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
            $role = new Role();
            $role->name = $request->input('name');
            $role->guard_name = $request->input('guard_name');
            $isSaved = $role->save();
            return response()->json(
                ["message" => $isSaved ? "The role saved Successfuly!" : "The role saved faild!"],
                $isSaved ? Response::HTTP_CREATED : Response::HTTP_BAD_REQUEST
            );
        } else {
            return response()->json(["message" => $validator->getMessageBag()->first()], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        $permissions = Permission::where("guard_name", "=", $role->guard_name)->get();
        $rolePermissions=$role->permissions;
        if(count($rolePermissions)>0){
            foreach($rolePermissions as $rolePermission){
                foreach($permissions as $permission){
                    //$permission->setAttribute("assigned", false);
                    if($rolePermission->id == $permission->id){
                        $permission->setAttribute("assigned",true);
                    }
                }

            }
        }
        return response()->view("cms.roles.role-permissions", compact("role", "permissions"));
    }

    public function updateRolePermission(Request $request)
    {
        $validator=Validator($request->all(),[
            "role_id"=>"required|numeric|exists:roles,id",
            "permission_id"=> "required|numeric|exists:permissions,id"
        ]);

        if(!$validator->fails()){
            $role=Role::findOrFail($request->input("role_id"));
            $permission = Permission::findOrFail($request->input("permission_id"));

            if($role->hasPermissionTo($permission)){
                $role->revokePermissionTo($permission);
            }else{
                $role->givePermissionTo($permission);
            }
            return response()->json(["message"=>"Updated Successfully!"],Response::HTTP_OK);

        }else{
            return response()->json(["message" => $validator->getMessageBag()->first()], Response::HTTP_BAD_REQUEST);


        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        return response()->view("cms.roles.edit", compact("role"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Role $role)
    {
        $validator = Validator($request->all(), [
            "guard_name" => "required|string|in:admin,web",
            "name" => "required|string"
        ]);

        if (!$validator->fails()) {
            $role->name = $request->input('name');
            $role->guard_name = $request->input('guard_name');
            $isUpdated = $role->save();
            return response()->json(
                ["message" => $isUpdated ? "The role updated Successfuly!" : "The role updated faild!"],
                $isUpdated ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST
            );
        } else {
            return response()->json(["message" => $validator->getMessageBag()->first()], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        $isDeleted = $role->delete();
        return response()->json(
            ["message" => $isDeleted ? "Deleted successfuly!" : "Deleted faild!"],
            $isDeleted ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST
        );
    }
}
