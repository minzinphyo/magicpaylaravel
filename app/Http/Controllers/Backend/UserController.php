<?php

namespace App\Http\Controllers\Backend;

use App\User;
use App\Wallet;
use Carbon\Carbon;
use Jenssegers\Agent\Agent;
use App\Http\Requests\StoreUser;
use Yajra\Datatables\Datatables;
use App\Http\Requests\UpdateUser;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{
    public function index(){
        return view('backend.user.index');

       //$admin_user = AdminUser::get();
       //$count = $admin_user->count();
       //return response(['count' => $count,'shops' => $admin_user->toArray(),], 200);
    }

    public function ssd(){
        $data = \App\User::query();
       //$data = \App\User::latest('created_at')->get();
       //$data = \App\User::latest('created_at');
      // $data = \App\User::select('id', 'name', 'email','phone','ip','user_agent','password', 'created_at', 'updated_at');
       //$data = \App\User::select(['id', 'name', 'email','phone','ip','user_agent','password', 'created_at', 'updated_at']);
     return Datatables::of($data)

            ->addColumn('action',function($each){

              if(auth()->id() == $each->id){
                 $edit_icon = '<a href= "'.route('admin.user.edit',$each->id).'" class="text-warning"><i class="fas fa-edit"></i></a>';
                 return '<div class="action-icon">' . $edit_icon .'</div>';
              }
                 $edit_icon = '<a href= "'.route('admin.user.edit',$each->id).'" class="text-warning"><i class="fas fa-edit"></i></a>';
                 $delete_icon = '<a href= "#" class="text-danger delete"  data-id = " '.$each->id.' "><i class="fas fa-trash"></i></a>';

                 return '<div class="action-icon">' . $edit_icon . $delete_icon . '</div>';


            })

            ->editColumn('created_at', function ($user) {
             return [
                 'display' => Carbon::parse($user->created_at)->format('d/m/Y'),
                 'timestamp' => $user->created_at->timestamp
             ];
            })
            /*
            ->editColumn('created_at',function($user){
                return Carbon::parse($user->created_at)->format('Y-m-d H:m:s');
            })*/
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
        return view('backend.user.create');
    }

    public function store(StoreUser $request){

        $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->password = Hash::make($request->password);
            $user->save();

            $wallet = Wallet::where('user_id',$user->id)->first();
            if(!$wallet){
                $wallet = new Wallet();
                $wallet->user_id = $user->id;
                $wallet->account_number = '1234123412341234';
                $wallet->amount = 0;
                $wallet->save();
            }

            return redirect()->route('admin.user.index')->with('create',"Successfully Created");




        /*
        DB::beginTransaction();

        try{





            Wallet::firstOrCreate(

                [
                    'user_id' =>  $user->id,
                ],

                [
                    'account_number' => '1234123412341234',
                    'amount' => 0,
                ]

            );
            //var_dump($user->id);

            DB::commit();

            return redirect()->route('admin.user.index')->with('create',"Successfully Created");


        }catch(\Exception $e){
            DB::rollBack();
            return back()->withErrors(['fail' => 'Something Wrong'])->withInput();
        }

        */


        //return response()->json(["message" => "Admin user created"], 201);
    }

    public function edit($id){
        $user = User::findOrFail($id);
        return view('backend.user.edit',compact('user'));
    }

    public function update($id,UpdateUser $request){
        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->password = $request-> password ? Hash::make($request->password) : $user->password;
        $user->update();

        return redirect()->route('admin.user.index')->with('create',"Successfully Updated");

        //return response()->json(["message" => "records updated successfully"], 200);
    }

    public function destroy($id){

        $user = User::findOrFail($id);
        $user->delete();

        return 'success';
        //return response()->json(["message" => "records deleted"], 202);
    }
}
