<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{
    function role_manage(){
        $permissions = Permission::all();
        $roles = Role::all();
        $users = User::all();
        return view('admin.role.role_permission', [
            'permissions'=>$permissions,
            'roles'=>$roles,
            'users'=>$users,
        ]);
    }
    function permission_store(Request $request){
        Permission::create(['name' => $request->permission_name]);

        return back()->with('success', 'Successfully Added!');
    }
    function role_store(Request $request){
        $role = Role::create(['name' => $request->role_name]);
        $role->givePermissionTo($request->permission);

        return back()->with('success_role', 'Successfully Added!');
    }
    function delete_role($id){
      Role::find($id)->delete();
      DB::table('role_has_permissions')->where('role_id', $id)->delete();

      return back()->with('delete_role', 'Successfully Added!');
    }
    function edit_role($id){
        $role = Role::find($id);
        $permissions = Permission::all();
        return view('admin.role.edit_role', [
            'permissions'=>$permissions,
            'role'=>$role,
        ]);
    }
    function update_role(Request $request, $id){
        $role = Role::find($id);
        $role->syncPermissions($request->permission);

        return back()->with('update_role', 'Successfully Updated!');
    }
    function assign_store(Request $request){
        $user = User::find($request->user_id);
        $user->assignRole($request->role);

        return back()->with('assign_role', 'Successfully Assigned!');
    }
    function remove_role(Request $request, $id){
        DB::table('model_has_roles')->where('model_id', $id)->delete();

        return back()->with('remove_role', 'Successfully Removed!');
    }
}
