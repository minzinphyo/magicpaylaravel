<?php

namespace App\Http\Controllers\Backend;

use App\User;
use Exception;
use Carbon\Carbon;
use App\Transaction;
use Illuminate\Http\Request;
use App\Helpers\UUIDGenerate;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class WalletController extends Controller
{
    public function index(){
        return view('backend.wallet.index');
    }

    public function ssd(){

       $wallet = \App\Wallet::with('user')->latest('created_at')->get();

     return Datatables::of($wallet)

           ->addColumn('account_person',function($each){
               $user = $each->user;
               if($user){
                   return '<p>Name : '.$user->name.' </p><p>Email : '.$user->email.' </p><p>Phone : '.$user->phone.' </p>';
               }
               return "-";
            })
            ->editColumn('amount', function ($each) {
                return number_format($each->amount,2);
            })
            ->editColumn('created_at', function ($user) {
                return [
                    'display' => Carbon::parse($user->created_at)->format('d/m/Y'),
                    'timestamp' => $user->created_at->timestamp
                ];
            })
            ->editColumn('updated_at', function ($user) {
                return [
                    'display' => Carbon::parse($user->updated_at)->format('d/m/Y'),
                    'timestamp' => $user->updated_at->timestamp
                ];
            })
            ->rawColumns(['account_person'])
            ->make(true);

    }

    public function addAmount(){
        $users = User::orderBy("name")->get();
        return view('backend.wallet.add_amount',compact('users'));
    }

    public function addAmountStore(Request $request){

        $request->validate(
            [
                'user_id' => 'required',
                'amount'  => 'required|integer',
            ],
            [
                'user_id.required' => 'The user field is required',
            ]

        );

        if($request->amount < 1000){
            return back()->withErrors(['amount' => 'The amount must be atleast 1000 MMK'])->withInput();
        }


        DB::beginTransaction();

        try{

          $to_account = User::with('wallet')->where('id',$request->user_id)->firstOrFail();

            $to_account_wallet = $to_account->wallet;
            $to_account_wallet->increment('amount',$request->amount);
            $to_account_wallet->update();

            $ref_no = UUIDGenerate::refNumber();

            $to_account_transaction = new Transaction();
            $to_account_transaction -> ref_no = $ref_no;
            $to_account_transaction -> trx_id = UUIDGenerate::trxId();
            $to_account_transaction -> user_id = $to_account->id;
            $to_account_transaction -> type = 1;
            $to_account_transaction -> amount = $request->amount;
            $to_account_transaction -> source_id = 0;
            $to_account_transaction -> description = $request->description;
            $to_account_transaction -> save();

            DB::commit();
            return redirect()->route('admin.wallet.index')->with('create','Successfully amount added.');
        }catch(Exception $error){
            DB::rollBack();
            return back()->withErrors(['fail' => 'Something wrong.' . $error->getMessage()])->withInput();
        }

    }

    public function reduceAmount(){
        $users = User::orderBy("name")->get();
        return view('backend.wallet.reduce_amount',compact('users'));
    }

    public function reduceAmountStore(Request $request){

        $request->validate(
            [
                'user_id' => 'required',
                'amount'  => 'required|integer',
            ],
            [
                'user_id.required' => 'The user field is required',
            ]

        );

        if($request->amount < 1){
            return back()->withErrors(['amount' => 'The amount must be atleast 1 MMK'])->withInput();
        }


        DB::beginTransaction();

        try{

          $to_account = User::with('wallet')->where('id',$request->user_id)->firstOrFail();

            $to_account_wallet = $to_account->wallet;

            if($to_account_wallet->amount < $request->amount){
                throw new Exception('The amount is greater than the wallet balance.');
            }
            $to_account_wallet->decrement('amount',$request->amount);
            $to_account_wallet->update();

            $ref_no = UUIDGenerate::refNumber();

            $to_account_transaction = new Transaction();
            $to_account_transaction -> ref_no = $ref_no;
            $to_account_transaction -> trx_id = UUIDGenerate::trxId();
            $to_account_transaction -> user_id = $to_account->id;
            $to_account_transaction -> type = 2;
            $to_account_transaction -> amount = $request->amount;
            $to_account_transaction -> source_id = 0;
            $to_account_transaction -> description = $request->description;
            $to_account_transaction -> save();

            DB::commit();
            return redirect()->route('admin.wallet.index')->with('create','Successfully amount reduced.');
        }catch(Exception $error){
            DB::rollBack();
            return back()->withErrors(['fail' => 'Something wrong.' . $error->getMessage()])->withInput();
        }

    }
}
