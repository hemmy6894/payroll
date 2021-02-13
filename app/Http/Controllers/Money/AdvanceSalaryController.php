<?php

namespace App\Http\Controllers\Money;

use App\Http\Controllers\Controller;
use App\Http\Helpers\DownloadHelper;
use App\Http\Helpers\PaginateHelper;
use App\Http\Helpers\RedirectHelper;
use App\Http\Helpers\WhereHelper;
use App\Models\Money\AdvanceSalaryModel;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdvanceSalaryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $advance = AdvanceSalaryModel::orderBy('id','ASC');
        $advance = WhereHelper::where_array($advance,['amount']);
        if(isset($_GET['user'])){
            $advance = WhereHelper::where_array($advance,['user_id'],'=','user');
        }
        if(isset($_GET['download'])){
            return $this->download($advance);
        }
        $advances = $advance->paginate(PaginateHelper::per_page());
        $download_link = RedirectHelper::donwnload_url(); 
        return view('advance.index',\compact('advances','download_link'));
    }

    protected function download($data){
        return DownloadHelper::csv(
            [
                __('words.employee_no'),
                __('words.name'),
                __('words.amount'),
                __('words.created_date'),
                __('words.paid_date'),
                __('words.comment'),
            ],
            [
                ['users','employee_no'],
                ['users','full_name'],
                'amount',
                'created_at',
                'paid_date',
                'comment'
            ],
            $data->get(),
            "AdvanceSalary.csv"
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $users = User::all();
        $user = "";
        if(isset($_GET['user'])){
            if(!empty($_GET['user'])){
                $user = $_GET['user'];
            }
        }
        $u = User::where('id',$user);
        if(!$u->count()){
            return RedirectHelper::not_found();
        }
        $user_id = $u->get()[0]->id;
        $user_name = $u->get()[0]->full_name;
        return view('advance.create',\compact('users','user_id','user_name'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $this->validate($request,[
            'user_id' => ['required'],
            'amount' => ['required','numeric'],
        ]);

        if($request->salary_month == "next"){
            $request_salary_month = Carbon::now()->addMonth()->format('Y-m-d');
        }else{
            $request_salary_month = Carbon::now()->format('Y-m-d');
        }
        
        if($this->allowed($request->user_id,$request->amount)){
            return RedirectHelper::back_error(__('words.salary_advance_must_be_half'),__('words.failed'),'warning');
        } 

        ///update
        //return $request->salary_month;
        
        $date = Carbon::createFromTimeString($request_salary_month . " 00:00:00");
        $year = $date->format('Y');
        $month = $date->format('m');
        $advance = AdvanceSalaryModel::where('user_id',$request->user_id)->whereMonth('salary_month',$month)->whereYear('salary_month',$year);
        if(!$advance->count()){
            $advance = AdvanceSalaryModel::create([
                'user_id' => $request->user_id,
                'salary_month' => $request_salary_month,
                'amount' => $request->amount,
                'comment' => $request->comment,
                'created_by' => Auth::user()->id,
            ]);
            return RedirectHelper::create_sms($advance->wasRecentlyCreated,'user.index');
        }else{
            $advance = $advance->update([
                'user_id' => $request->user_id,
                'salary_month' => $request_salary_month,
                'amount' => $request->amount,
                'comment' => $request->comment,
            ]);
            return RedirectHelper::update_sms($advance,'user.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Auth\AdvanceSalaryModel  $advanceModel
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $advance = AdvanceSalaryModel::where('id',$id);
        if(!$advance->count()){
            return RedirectHelper::not_found();
        }

        $disabled = "disabled";
        $advance = $advance->get()[0];
        return view('advance.edit',compact('advance','disabled'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Auth\AdvanceSalaryModel  $advanceModel
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $advance = AdvanceSalaryModel::where('id',$id);
        if(!$advance->count()){
            return RedirectHelper::not_found();
        }
        if(isset($_GET['block'])){
            return RedirectHelper::block_user($advance);
        }
        $users = User::all();
        $advance = $advance->get()[0];
        return view('advance.edit',compact('advance','users'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Auth\AdvanceSalaryModel  $advanceModel
     * @return \Illuminate\Http\Response
     */
    public function update($id, Request $request)
    {
        //
        $this->validate($request,[
            'user_id' => ['required','exists:users'],
            'salary_month' => ['required','date'],
            'amount' => ['required','numeric'],
        ]);

        $advance = AdvanceSalaryModel::where('id',$id);
        if(!$advance->count()){
            return RedirectHelper::not_found();
        }

        if($this->allowed($request->user_id,$request->amount)){
            return RedirectHelper::back_error(__('words.salary_advance_must_be_half'),__('words.failed'),'warning');
        }
        $advance = $advance->update([
            'user_id' => $request->user_id,
            'salary_month' => $request->salary_month,
            'amount' => $request->amount,
        ]);
        return RedirectHelper::update_sms($advance,'advance.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Auth\AdvanceSalaryModel  $advanceModel
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
        //
    }

    public function allowed($user,$advance){
        $user = User::where('id',$user);
        if($user->count()){
            if(($user->get()[0]->basic_salary / 2) >= $advance){
                return false;
            }
        }
        return true;
    }
}
