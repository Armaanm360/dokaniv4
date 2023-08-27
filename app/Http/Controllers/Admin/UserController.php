<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Role;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\Designation;
use Illuminate\Support\Facades\Hash;
use App\Models\Department;
use App\Models\Institutions;
use App\Events\Notification;
use App\Models\Division;
use App\Models\Ministry;
use App\Models\Office;
use App\Models\Regularityauthority;
use App\Models\UnitOffice;

class UserController extends Controller
{ 

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

      $data['all_roles'] = Role::all();
      $data['users'] = User::latest()->get();
      return view('admin.pages.user.user_list',$data);
       
    }

    public function user_list(Request $request)
    {
        $draw = intval($request->draw);
        $start = intval($request->start);
        $limit = intval($request->length);
        $sortBy = null;
        $sortDirection = '';
        //        print_r($request->order);die;
        if (isset($request->order[0]['column'])) {
            $sortBy = $request->columns[$request->order[0]['column']]['data'];
            $sortDirection = $request->order[0]['dir'];
        }

        $searchArr1 = $request->columns;
        $except_first_array = array_slice($searchArr1, count($searchArr1) - (count($searchArr1) - 1), count($searchArr1));

        $searchArr = array_slice($except_first_array, '-' . count($except_first_array), 5);

        //         echo "<pre>";print_r($searchArr);die;

        if (Auth::user()->hasRole('super-admin')) {
            $total_data = DB::table('users')
                ->when($searchArr, function ($query) use ($searchArr, $start, $limit) {
                    foreach ($searchArr as $searchRow) {
                        $searchRowdata = $searchRow['data'];
                        $searchRowvalue = $searchRow['search']['value'];
                        $query->orWhere($searchRowdata, "LIKE", "%" . $searchRowvalue . "%");
                    }
                })
                ->when($sortBy, function ($query, $sortBy) use ($sortDirection) {
                    return $query->orderBy($sortBy, $sortDirection);
                }, function ($query) {
                    return $query->orderBy('id', 'desc');
                })
                ->count();

            $user_list = DB::table('users')
                ->leftJoin("users_roles", "users.id", "=", "users_roles.user_id")
                ->leftJoin("roles", "roles.id", "=", "users_roles.role_id")
                ->leftJoin("designations", "designations.id", "=", "users.designation")
                ->when($sortBy, function ($query, $sortBy) use ($sortDirection) {
                    return $query->orderBy($sortBy, $sortDirection);
                }, function ($query) {
                    return $query->orderBy('id', 'desc');
                })
                ->select("users.*", "roles.id AS role_id", "roles.name AS role_name", "designations.name AS designation_name")
                ->when($searchArr, function ($query) use ($searchArr, $start, $limit) {
                    foreach ($searchArr as $searchRow) {
                        $searchRowdata = $searchRow['data'];
                        $searchRowvalue = $searchRow['search']['value'];
                        $query->orWhere("users.$searchRowdata", "LIKE", "%$searchRowvalue%");
                    }
                })
                ->offset($start)
                ->limit($limit)
                ->get();
        } else {

            $total_data = DB::table('users')
                ->whereInstitutionId(Auth::user()->institution_id)
                ->when($searchArr, function ($query) use ($searchArr, $start, $limit) {
                    foreach ($searchArr as $searchRow) {
                        $searchRowdata = $searchRow['data'];
                        $searchRowvalue = $searchRow['search']['value'];
                        $query->where($searchRowdata, "LIKE", "%" . $searchRowvalue . "%");
                    }
                })
                ->when($sortBy, function ($query, $sortBy) use ($sortDirection) {
                    return $query->orderBy($sortBy, $sortDirection);
                }, function ($query) {
                    return $query->orderBy('id', 'desc');
                })
                ->count();

            $user_list = DB::table('users')
                ->where('users.institution_id', '=', Auth::user()->institution_id)
                ->leftJoin("users_roles", "users.id", "=", "users_roles.user_id")
                ->leftJoin("roles", "roles.id", "=", "users_roles.role_id")
                ->leftJoin("designations", "designations.id", "=", "users.designation")
                ->when($sortBy, function ($query, $sortBy) use ($sortDirection) {
                    return $query->orderBy($sortBy, $sortDirection);
                }, function ($query) {
                    return $query->orderBy('id', 'desc');
                })
                ->select("users.*", "roles.id AS role_id", "roles.name AS role_name", "designations.name AS designation_name")
                ->when($searchArr, function ($query) use ($searchArr, $start, $limit) {
                    foreach ($searchArr as $searchRow) {
                        $searchRowdata = $searchRow['data'];
                        $searchRowvalue = $searchRow['search']['value'];
                        $query->where("users.$searchRowdata", "LIKE", "%$searchRowvalue%");
                    }
                })
                ->offset($start)
                ->limit($limit)
                ->get();
        }


        //        echo '<pre>';print_r($user_list);die;
        $data = array();
        $i = 1;

        $user = Auth::user();
        //        $user->can('add-vendor');

        foreach ($user_list as $row) {
            $action = '';
            $message = 'Are You Sure want to delete';
            if ($user->can('view-user')) {
                $action .= "<a class='btn btn-primary btn-sm mr-2' href='users/" . $row->id . "'>View</a>";
            }
            if ($user->can('edit-user')) {
                $action .= "<a class='btn btn-success btn-sm mr-2' href='users/" . $row->id . "/edit'>Edit</a>";
            }
            if ($user->can('delete-user')) {
                $action .= "<form action='" . route('users.destroy', $row->id) . "' method='POST' style='display: inline-block;'>"
                    . csrf_field() . ""
                    . method_field('DELETE') . "
                            <button class='btn btn-danger btn-sm' type='submit'>Delete</button>
                        </form>";
            }


            $user_array['sl'] = $i;
            $user_array['name'] = $row->name;
            $user_array['email'] = $row->email;
            $user_array['phone'] = $row->phone;
            $user_array['user_id'] = $row->user_id;
            $user_array['designation'] = $row->designation_name;
            $user_array['role_name'] = $row->role_name;
            $user_array['action'] = $action;

            $data[] = $user_array;
            $i++;
        }

        $output = array(
            "draw" => $draw,
            "recordsTotal" => $total_data,
            "recordsFiltered" => $total_data,
            "data" => $data
        );
        echo json_encode($output);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $data['all_roles'] = Role::all();
        return view('admin.pages.user.create_user', $data);
        // if (Auth::user()->can('add-user')) {
        //     SwitchLanguage(Session::get('language'));
        //     if (Auth::user()->hasRole('super-admin')) {
        //         $data['all_designation'] = Designation::all();
        //         $data['all_division'] = Division::all();
        //         $data['all_roles'] = Role::all();
        //         $data['all_employees'] = User::all();
        //         $data['all_department'] = Department::all();
        //         $data['all_institutions'] = Institutions::all();
        //         $data['all_ministry'] = Ministry::all();
        //         $data['all_organization_users'] = Office::all();
        //         $data['all_regulatory_authority'] = Regularityauthority::all();
        //         $data['all_branch'] = UnitOffice::all();
        //     } else {
        //         $data['all_designation'] = Designation::whereInstitutionId(Auth::user()->institution_id)->get();
        //         $data['all_division'] = Division::whereInstitutionId(Auth::user()->institution_id)->get();
        //         $data['all_roles'] = Role::whereInstitutionId(Auth::user()->institution_id)->get();
        //         $data['all_employees'] = User::whereInstitutionId(Auth::user()->institution_id)->get();
        //         $data['all_department'] = Department::whereInstitutionId(Auth::user()->institution_id)->get();
        //         $data['all_institutions'] = Institutions::whereId(Auth::user()->institution_id)->get();
        //         $data['all_ministry'] = Ministry::whereId(Auth::user()->institution_id)->get();
        //         $data['all_organization_users'] = Office::whereId(Auth::user()->institution_id)->get();
        //         $data['all_regulatory_authority'] = Regularityauthority::whereId(Auth::user()->institution_id)->get();
        //         $data['all_branch'] = UnitOffice::whereId(Auth::user()->institution_id)->get();
        //     }
        //     return view('admin.pages.user.create_user', $data);
        // }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $request->validate([
        //     'name' => 'required',
        //     'email' => 'required|unique:users',
        //     'designation' => 'required',
        //     'division' => 'required',
        //     'password' => 'required|min:8|required_with:confirm_password|same:confirm_password',
        //     'confirm_password' => 'min:8',
        //     'role' => 'required'
        // ]);

        $user = new User;

        $user->name = $request->name;
        if ($request->image) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('user_images'), $imageName);
            $user->image = $imageName;
        }


        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->role = $request->role;
        $user->password = Hash::make($request->password);
        $user->save();
        
        


        $user_role['role_id'] = $request->role;
        $user_role['user_id'] = $user->id;

        $user_save = DB::table('users_roles')->insert($user_role);

        $permissions = DB::table('roles_permissions')
            ->where('role_id', $request->role)
            ->get();
        foreach ($permissions as $rowPermission) {
            $datasave['user_id'] = $user->id;
            $datasave['permission_id'] = $rowPermission->permission_id;
            DB::table('users_permissions')->insert($datasave);
        }
        //       $purmission_holder = $request->permission_holder_id;
        // foreach ($request->permission_holder_id as $rowId) {
        //     $datasave1['user_id'] = $user->id;
        //     $datasave1['permision_holder_id'] = $rowId;
        //     $datasave1['created_by'] = Auth::user()->id;
        //     $datasave1['status'] = 1;
        //     DB::table('user_leave_permission')->insert($datasave1);
        // }

        if ($request->department_id) {
            foreach ($request->department_id as $rowId) {
                $datasave2['user_id'] = $user->id;
                $datasave2['department_id'] = $rowId;
                DB::table('user_departments')->insert($datasave2);
            }
        }
        // if ($request->alter_user_id) {
        //     foreach ($request->alter_user_id as $rowId) {
        //         $datasave3['user_id'] = $user->id;
        //         $datasave3['alternate_user_id'] = $rowId;
        //         $datasave3['status'] = 1;
        //         DB::table('alternate_users')->insert($datasave3);
        //     }
        // }

        // if ($user_save) {
        //     Session::put(['title' => 'Alert', 'message' => 'User has been created successfully!']);
        //     $msg = 'Report Management user email : ' . $request->email . ' & Password : ' . $request->password;
        //     sendMail('m360ict@gmail.com', $request->email, 'Report  Management', $msg);


        //     // $to_user_data = User::find($user->id);
        //     // $sendNotification = 'Hello ' . $request->name . " . Welcome to the Report Management System, Financial Institution Division,Ministry of Finance, Bangladesh.";
        //     // $link = 'report-requests/show' . '/demo';
        //     // event(new Notification(\Illuminate\Support\Facades\Auth::user()->id, $to_user_data->id, $sendNotification, $link));

		// 				            $to_user_data = User::find($user->id);
        //     $sendNotification = 'Hello ' . $request->name . " . Welcome to the Report Management System, Financial Institution Division,Ministry of Finance, Bangladesh.";
        //     $link = '';
        //     event(new Notification(\Illuminate\Support\Facades\Auth::user()->id, $to_user_data->id, $sendNotification, $link));


        //     $password_change = User::find($user->id);
        //     $sendNotification = 'Hello ' . $request->name . " . Your are requested to change your password.";
        //     $link = 'usersedit/'.$user->id.'';
        //     event(new Notification(\Illuminate\Support\Facades\Auth::user()->id, $password_change->id, $sendNotification, $link));
        // }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data['user'] = User::find($id);
        $data['get_role'] = Role::where('id',$data['user']->role)->get();
        return view('admin.pages.user.view_user', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // $abc = \App\Models\User::find($id)->permission_holder;
        // foreach ($abc as $rowpl) {
        //     $datapl[] = "'$rowpl->permision_holder_id'";
        //               //  print_r($datapl);
        // }
        // if (isset($datapl)) {
        //     $data['permission_holders'] = implode(',', $datapl);
        // }


        // if (Auth::user()->hasRole('super-admin')) {
        //     $data['all_designation'] = Designation::all();
        //     $data['all_division'] = Division::all();
        //     $data['all_institutions'] = Institutions::all();
        //     $data['all_roles'] = Role::all();
        //     $data['all_employees'] = User::all();
        //     $data['all_department'] = Department::all();

        //     $data['all_ministry'] = Ministry::all();
        //     $data['all_organization_users'] = Office::all();
        //     $data['all_regulatory_authority'] = Regularityauthority::all();
        //     $data['all_branch'] = UnitOffice::all();
        //     // $data['user_type'] = DB::table('users')
        //     //                     ->select('users.user_type')
        //     //                     ->where('users.id', $id)
        //     //                     ->get();

        //     $data['userData'] = DB::table('users')
        //         ->leftJoin('users_roles', 'users.id', '=', 'users_roles.user_id')
        //         ->leftJoin('roles', 'users_roles.role_id', '=', 'roles.id')
        //         ->where('users.id', $id)
        //         ->select('users.*', 'roles.id AS role_id', 'roles.name AS role_name')
        //         ->first();

        //     $departments = DB::table('user_departments')
        //         ->where('user_departments.user_id', $id)
        //         ->get();
        // } else {


            $data['userData'] = DB::table('users')
                ->leftJoin('users_roles', 'users.id', '=', 'users_roles.user_id')
                ->leftJoin('roles', 'users_roles.role_id', '=', 'roles.id')
                ->where('users.id', $id)
                ->select('users.*', 'roles.id AS role_id', 'roles.name AS role_name')
                ->first();

        // }


        //     


        // $datapl[] = '';
        //         foreach ($departments as $rowpl) {
        //             $datapl[] = $rowpl->department_id;
        //         }
        //         if (count($datapl) != 0) {
        //             $data['user_departments'] = $datapl;
        //         } else {
        //             $data['user_departments'] = "";
        //         }


        $data['all_roles'] = Role::all();
        return view('admin.pages.user.edit_user',$data);
    }



    public function editUser($id,$def=null)
    {
        SwitchLanguage(Session::get('language'));
        $abc = \App\Models\User::find($id)->permission_holder;
        foreach ($abc as $rowpl) {
            $datapl[] = "'$rowpl->permision_holder_id'";
            //            print_r($datapl);
        }
        if (isset($datapl)) {
            $data['permission_holders'] = implode(',', $datapl);
        }


        if (Auth::user()->hasRole('super-admin')) {
            $data['all_designation'] = Designation::all();
            $data['all_division'] = Division::all();
            $data['all_institutions'] = Institutions::all();
            $data['all_roles'] = Role::all();
            $data['all_employees'] = User::all();
            $data['all_department'] = Department::all();

            $data['userData'] = DB::table('users')
                ->leftJoin('users_roles', 'users.id', '=', 'users_roles.user_id')
                ->leftJoin('roles', 'users_roles.role_id', '=', 'roles.id')
                ->where('users.id', $id)
                ->select('users.*', 'roles.id AS role_id', 'roles.name AS role_name')
                ->first();

            $departments = DB::table('user_departments')
                ->where('user_departments.user_id', $id)
                ->get();
        } else {


            $data['userData'] = DB::table('users')
                ->leftJoin('users_roles', 'users.id', '=', 'users_roles.user_id')
                ->leftJoin('roles', 'users_roles.role_id', '=', 'roles.id')
                ->where('users.id', $id)
                ->where('users.institution_id', Auth::user()->institution_id)
                ->select('users.*', 'roles.id AS role_id', 'roles.name AS role_name')
                ->first();

								// echo '<pre>';
								// print_r(Auth::user());
								// echo '<pre>';

                // die;
                // $data['all_roles']         = Role::where('institution_id',Auth::user()->role_id)->get();
                // $data['all_employees']     = User::where('institution_id',Auth::user()->user_id)->get();
                // $data['all_department']     = Department::where('institution_id',Auth::user()->department)->get();
                // $data['all_designation']     = Designation::where('institution_id',Auth::user()->designation)->get();
                // $data['all_division']     = Division::where('institution_id',Auth::user()->division)->get();
                // $data['all_institutions']     = Institutions::whereId(Auth::user()->institution_id)->get();
                $data['all_department']       = Department::where('institution_id',Auth::user()->institution_id)->get();
								$data['all_roles']            = Role::where('institution_id',Auth::user()->institution_id)->get();
								$data['all_employees']        = User::where('institution_id',Auth::user()->institution_id)->get();
								$data['all_division']         = Division::where('institution_id',Auth::user()->institution_id)->get();
								$data['all_institutions']     = Institutions::where('id',Auth::user()->institution_id)->get();
								$data['all_designation']      = Designation::where('institution_id',Auth::user()->institution_id)->get();
								// echo '<pre>';
								// print_r($data['all_institutions']);die;
								// echo '<pre>';
	
								
								// die;
								

            $departments = DB::table('user_departments')
                ->where('user_departments.user_id', $id)
                ->get();


								// $institutions = DB::table('institutions')
            //     ->where('institutions.id', $id)
            //     ->get();


					// print_r($data['all_designation'] );die;
            // $data['all_roles']         = Role::whereInstitutionId(Auth::user()->institution_id)->get();
            // $data['all_employees']     = User::whereInstitutionId(Auth::user()->institution_id)->get();
            // $data['all_department']    = Department::whereInstitutionId(Auth::user()->institution_id)->get();
            // $data['all_designation']   = Designation::whereInstitutionId(Auth::user()->institution_id)->get();
            // $data['all_division']      = Division::whereId(Auth::user()->institution_id)->get();
            // $data['all_institutions']     = Institutions::whereId(Auth::user()->institution_id)->get();
        }


        //     

        foreach ($departments as $rowpl) {
            $datapl[] = $rowpl->department_id;
        }
        if (count($datapl) != 0) {
            $data['user_departments'] = $datapl;
        } else {
            $data['user_departments'] = "";
        }
        $alternate_users = DB::table('alternate_users')
            ->where('alternate_users.user_id', $id)
            ->get();
        foreach ($alternate_users as $rowpl) {
            $datapl[] = $rowpl->alternate_user_id;
        }
        if (count($datapl) != 0) {
            $data['alternate_users'] = $datapl;
        } else {
            $data['alternate_users'] = "";
        }



        return view('admin.pages.user.edit_user', $data);
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
        //           print_r($request->permission_holder_id);
        //           die;
        // $request->validate([
        //     'name' => 'required',
        //     'email' => 'required',
        //     'role' => 'required',
        //     'designation' => 'required',
        //     'division' => 'required',
        // ]);

        $user = User::find($id);

        $user->name = $request->name;
        if ($request->image) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('user_images'), $imageName);
            $user->image = $imageName;
        }
//        print_r($request->signature);
                 if ($request->signature) {
            $imageName1 = time() . '.' . $request->signature->extension();
            $request->signature->move(public_path('user_images'), $imageName1);
            $user->signature = $imageName1;
        }
        
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->role = $request->role;
        if ($request->password) {
            $user->password = Hash::make($request->password);
        }
        $user->save();
        $user_role['role_id'] = $request->role;
        $user_role['user_id'] = $user->id;

        DB::table('users_roles')
            // ->where('role_id', '=', $request->role)
            ->where('user_id', '=', $user->id)
            ->delete();

        $user_save = DB::table('users_roles')->insert($user_role);

        $permissions = DB::table('roles_permissions')
            ->where('role_id', $request->role)
            ->get();
        //       print_r($permissions);
        foreach ($permissions as $rowPermission) {
            DB::table('users_permissions')
                ->where('user_id', '=', $user->id)
                ->where('permission_id', '=', $rowPermission->permission_id)
                ->delete();
            $datasave['user_id'] = $user->id;
            $datasave['permission_id'] = $rowPermission->permission_id;
            DB::table('users_permissions')->insert($datasave);
        }


        if ($user_save) {
            Session::put(['title' => 'Alert', 'message' => 'User has been updated successfully!']); //             
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();
        
        // if ($user) {
        //     Session::put(['title' => 'Alert', 'message' => 'User has been deleted successfully!']); //             
        // }

        // return redirect('users');
    }
}