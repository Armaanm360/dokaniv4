<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Permission;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\Institutions;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
            $data['all_permissions'] = Permission::all();           
            return view("admin.pages.permission.list_permission", $data);
//        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {     
      return view('admin.pages.permission.create_permission');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
//        print_r($request->all());die;
      
            $request->validate([
                'section_name'  => 'required',
                'name.*'        => 'required',
            ]);

            $permissions = $request->name;
            foreach ($permissions as $row) {
                $permission = new Permission;
                
                $permission->section_name = $request->section_name;
                $permission->name = $row;
                
     
            $permission->slug = str_replace(' ', '-', strtolower($row));
                
                $permission->save();
                if($permission){
                     Session::put(['title'=>'Alert!','message'=>'Permission save successfully!']);//             
                }
             
                
            }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
            $data['permission_data'] = Permission::find($id);
            return view("admin.pages.permission.edit_permission", $data);
//        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
//         if(Auth::user()->hasRole('super-admin')){
            $request->validate([
                'name' => 'required',
            ]);

           
            $permissions = $request->name;
            foreach ($permissions as $row) {
                $permission = Permission::find($id);
                
                $permission->section_name = $request->section_name;
                $permission->name = $row;
                
     
                $permission->slug = str_replace(' ', '-', strtolower($row));
                
                $permission->save();
                  if($permission){
                     Session::put(['title'=>'Alert!','message'=>'Permission Updated successfully!']);//             
                }
            }
//        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       $permission = Permission::find($id)->delete();
          if($permission){
                     Session::put(['title'=>'Alert!','message'=>'Permission deleted successfully!']);//             
                }
        return redirect('permissions');
    }
}
