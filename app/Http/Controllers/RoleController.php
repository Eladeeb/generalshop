<?php

namespace App\Http\Controllers;

use App\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::paginate(env("PAGINATION_COUNT"));
        return view('admin.roles.roles')->with([
            'roles' => $roles,
            'showLinks' => true
        ]);
    }
    public function store(Request $request)
    {
        $request->validate([
            'role_name'=>'required',

        ]);
        $roleName=$request->input('role_name');

        if(!$this->roleNameExists($roleName)){
            Session::flash('message','Role Name ('.$roleName.') already exists');
            return redirect()->back();
        }
        $role=Role::where('role','=',$roleName)->get();

        if( count($role) > 0  ){
            Session::flash('message','Tag '.$roleName.' already exists');
            return redirect()->back();
        }

        $newRole = new Role();
        $newRole->role =$roleName;
        $newRole->save();
        Session::flash('message','Role '.$roleName.' has been added');
        return redirect()->back();

    }
    public function search(Request $request){
        $request->validate([
            'role_search'=>'required',
        ]);
        $searchTerm=$request->input('role_search');
        $roles=Role::where(
            'role','LIKE','%'.$searchTerm.'%'
        )->get();


        if( count($roles) > 0 ){
            return view('admin.roles.roles')->with([
                'roles'=>$roles ,
                'showLinks'=> false ,
            ]);

        }

        Session::flash('message','Nothing Found!!!');
        return redirect()->back();
    }
    public function delete(Request $request)
    {
        $request->validate([
            'role_id'=>'required'
        ]);
        $roleID = $request->input('role_id');
        Role::destroy($roleID);

        Session::flash('message','Tag has been deleted');
        return redirect()->back();
    }
    public function update(Request $request)
    {

        $request->validate([
            'role_id'=>'required',
            'role_name'=>'required',
        ]);

        $roleName=$request->input('role_name');
        $roleID=$request->input('role_id');
        if(!$this->roleNameExists($roleName)){
            Session::flash('message','Tag Name ('.$roleName.') already exists');
            return redirect()->back();
        }


        $roleID=intval($roleID);
        $role=Role::find($roleID);
        $role->role =$roleName;
        $role->save();
        Session::flash('message','Unit '.$roleName.' has been updated');
        return redirect()->back();

    }
    private function roleNameExists($roleName){
        $role=Role::where(
            'role','=',$roleName
        )->first();
        if( !is_null($role) ){
            Session::flash('message','Role Name ('.$roleName.') already exists');
            return false;
        }
        return true ;
    }

}

