<?php

namespace App\Http\Controllers\Backend;

use App\AdminUser;
use Jenssegers\Agent\Agent;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Yajra\Datatables\Datatables;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\StoreAdminUser;
use App\Http\Requests\UpdateAdminUser;
use Illuminate\Support\Facades\Response;

class AdminUserController extends Controller
{
    public function index(){
        return view('backend.admin_user.index');

       //$admin_user = AdminUser::get();
       //$count = $admin_user->count();
       //return response(['count' => $count,'shops' => $admin_user->toArray(),], 200);
    }

    public function ssd(){
         //$data = \App\AdminUser::query();
       $data = \App\AdminUser::latest('created_at')->get();
       //$data = \App\AdminUser::latest('created_at');
      // $data = \App\AdminUser::select('id', 'name', 'email','phone','ip','user_agent','password', 'created_at', 'updated_at');
       //$data = \App\AdminUser::select(['id', 'name', 'email','phone','ip','user_agent','password', 'created_at', 'updated_at']);
     return Datatables::of($data)

            ->addColumn('action',function($each){

              if(auth()->id() == $each->id){
                 $edit_icon = '<a href= "'.route('admin.admin-user.edit',$each->id).'" class="text-warning"><i class="fas fa-edit"></i></a>';
                 return '<div class="action-icon">' . $edit_icon .'</div>';
              }
                 $edit_icon = '<a href= "'.route('admin.admin-user.edit',$each->id).'" class="text-warning"><i class="fas fa-edit"></i></a>';
                 $delete_icon = '<a href= "#" class="text-danger delete"  data-id = " '.$each->id.' "><i class="fas fa-trash"></i></a>';

                 return '<div class="action-icon">' . $edit_icon . $delete_icon . '</div>';


            })
            ->editColumn('created_at', function ($user) {
                return [
                    'display' => Carbon::parse($user->created_at)->format('d/m/Y'),
                    'timestamp' => $user->created_at->timestamp
                ];
            })
            ->editColumn('user_agent',function($each){
               if($each->user_agent){
                 $agent = new Agent();
                 $agent->setUserAgent($each->user_agent);
                 if($agent->isDesktop()){
                     $result = "Desktop";
                 }elseif($agent->isMobile()){
                     $result = "Mobile";
                 }else{
                     $result = "MacBook";
                 }


                 $device = $agent->device();
                 $platform = $agent->platform();
                 $browser = $agent->browser();
                 return '<table class="table table-bordered">
                 <tbody>
                    <tr><td>Device</td><td>'.$result.'</td></tr>
                    <tr><td>Platform</td><td>'.$platform.'</td></tr>
                    <tr><td>Browser</td><td>'.$browser.'</td></tr>
                 </tbody>
                 </table>';
               }
               return "-";
            })
            ->rawColumns(['user_agent','created_at','action'])
            ->make(true);
    }

    public function create(){
        return view('backend.admin_user.create');
    }

    public function store(StoreAdminUser $request){
        $admin_user = new \App\AdminUser();
        $admin_user->name = $request->name;
        $admin_user->email = $request->email;
        $admin_user->phone = $request->phone;
        $admin_user->password = Hash::make($request->password);
        $admin_user->save();

        return redirect()->route('admin.admin-user.index')->with('create',"Successfully Created");
        //return response()->json(["message" => "Admin user created"], 201);
    }

    public function edit($id){
        $admin_user = AdminUser::findOrFail($id);
        return view('backend.admin_user.edit',compact('admin_user'));
    }

    public function update($id,UpdateAdminUser $request){
        $admin_user = AdminUser::findOrFail($id);
        $admin_user->name = $request->name;
        $admin_user->email = $request->email;
        $admin_user->phone = $request->phone;
        $admin_user->password = $request-> password ? Hash::make($request->password) : $admin_user->password;
        $admin_user->update();

        return redirect()->route('admin.admin-user.index')->with('create',"Successfully Updated");

        //return response()->json(["message" => "records updated successfully"], 200);
    }

    public function destroy($id){

        $admin_user = AdminUser::findOrFail($id);
        $admin_user->delete();

        return 'success';
        //return response()->json(["message" => "records deleted"], 202);
    }
}
