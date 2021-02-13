<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Helpers\CalculationHelper;
use App\Http\Helpers\DownloadHelper;
use App\Http\Helpers\PaginateHelper;
use App\Http\Helpers\RedirectHelper;
use App\Http\Helpers\WhereHelper;
use App\Models\Auth\DepartmentModel;
use App\Models\Auth\EmployeeStatusModel;
use App\Models\Auth\GenderModel;
use App\Models\Auth\RoleModel;
use App\Models\Money\PayrollModel;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use BPDF as PDF;
use Carbon\Carbon;
use App\Models\Auth\UserAttachmentModel;
use Illuminate\Support\Facades\Auth;
use Excel;
use App\Excels\WcfExport;
use App\Excels\PspfExport;
use App\Models\Helpers\UserUpdateModel;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('guest');
    }

    public function index(){
        
        $users = User::orderBy('id','ASC');
        if(!isset($_GET['system'])){
            $users->where('employee_status','!=',3);
        }else{
            $users->where('employee_status','=',3);
        }
        
        if(!isset($_GET['all'])){
            $users->where('employee_status',1);
        }
        $users = WhereHelper::where_array($users,['lname','fname','sname','national_id'],'like');
        if(isset($_GET['download'])){
            $header = ['Rosper School ' . date('M, Y')];
            return $this->download($users,$header);
        }
        if(isset($_GET['download_wcf'])){
            return $this->download_wcf($users);
        }
        if(isset($_GET['download_pspf'])){
            return $this->download_pspf($users);
        }

        if(isset($_GET['past'])){
            return view('settings.user.past');
        }

        if(isset($_GET['payslip'])){
            if(isset($_GET['payslip'])){
                return $this->download_payslip();
            }
        }
        $users = $users->paginate(PaginateHelper::per_page());
        $download_link = RedirectHelper::donwnload_url();
        $download_wcf = RedirectHelper::donwnload_url('download_wcf');
        $payslip = RedirectHelper::payslip();
        if(isset($_GET['all'])){
            return view('settings.user.user_index',compact('users','download_link','payslip'));
        }
        return view('settings.user.index',compact('users','download_link','payslip'));
    }

    protected function download_payslip(){
        $payslip = $_GET['payslip'];
        $pay_user = User::where('id',$payslip);
        $m = null;
        $y = null;
        if(isset($_GET['month'])){
            if(!empty($_GET['month'])){
                $month = Carbon::createFromTimeString($_GET['month'] . "-1 0:00:00");
                $m = $month->format('m');
                $y = $month->format('Y');
                $pay_user = PayrollModel::where('user_id',$payslip)->whereMonth('month',$m)->whereYear('month',$y);
                $m = $month->format('F');
                $y = $month->format('Y');
            }
        }
        if(!$pay_user->count()){
            return RedirectHelper::not_found();
        }
        $pay_user = $pay_user->get()[0];
        
        if(isset($_GET['month'])){
            if(!empty($_GET['month'])){
                $name = $pay_user->users->full_name;
                if($pay_user->users()->count()){
                    $user = $pay_user->users()->get()[0];
                    $department = $user->departments->name;
                    $employee_no = $user->employee_no;
                    $pension_no = $user->pension_no;
                    $account_no = $user->account_no;
                    $basic_salary = $user->basic_salary;
                    $advance = $user->advance();
                    $active_loan = $user->active_loan;
                    $id = $user->id;
                    $active_loan_board = $user->active_loan_board;
                    $active_bft_loan = $user->active_bft_loan;
                }
            }
        }else{
            $name = $pay_user->full_name;
            $department = $pay_user->departments->name;
            $employee_no = $pay_user->employee_no;
            $pension_no = $pay_user->pension_no;
            $account_no = $pay_user->account_no;
            $basic_salary = $pay_user->basic_salary;
            $advance = $pay_user->advance();
            $active_loan = $pay_user->active_loan;
            $id = $pay_user->id;
            $active_loan_board = $pay_user->active_loan_board;
            $active_bft_loan = $pay_user->active_bft_loan;
        }
        
        $name = strtoupper($name);
        $pdf = PDF::loadView('pages.payslip',\compact('name','pay_user','department','employee_no','pension_no','account_no','basic_salary','advance','active_loan','id','active_loan_board','active_bft_loan','m','y'));
        return $pdf->download($name.".pdf");
    }
    protected function download($users,$header=[]){
        return DownloadHelper::user(
            [
                __('words.name'),
                __('words.basic_salary'),
                __('words.pension'),
                __('words.paye'),
                __('words.advance'),
                __('words.loan'),
                __('words.loan_board'),
                __('words.net_salary'),
                __('words.sdl'),
                
            ],
            $users->get(),
            "users.csv",
            $header
        );
    }

    protected function download_wcf($users){
        return Excel::download(new WcfExport,'wcf.xlsx');
    }

    protected function download_pspf($users){
        return Excel::download(new PspfExport,'nssf.xlsx');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'surnname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(Request $request)
    {
        $departments = DepartmentModel::active()->get();
        $genders = GenderModel::active()->get();
        $statuses = EmployeeStatusModel::active()->get();
        $roles = RoleModel::active()->get();
        if(isset($_GET['status'])){
            if(!empty($_GET['status'])){
                $state = $_GET['status'];
            }
        }
        return view('settings.user.create',compact('departments','genders','statuses','roles','state'));
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function store(Request $request)
    {
        $this->validate($request,[
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'surname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
            'gender' => ['required', 'string'],
            'department' => ['required', 'string'],
            'status' => ['required', 'string'],
            'role' => ['required', 'string'],
        ]);
        $data = $request->all();
        $user = User::create([
            'fname' => $data['first_name'],
            'lname' => $data['last_name'],
            'sname' => $data['surname'],
            'email' => $data['email'],
            'gender' => $data['gender'],
            'department_id' => $data['department'],
            'employee_status' => $data['status'],
            'roles' => $data['role'],
            'password' => Hash::make($data['password']),
        ]);
       return RedirectHelper::create_sms($user->wasRecentlyCreated);
    }

    public function show($id){
        $user = User::where('id',$id);
        if(!$user->count()){
            return RedirectHelper::not_found();
        }

        //die($user->get());
        $disabled = "disabled";
        $departments = DepartmentModel::all();
        $genders = GenderModel::all();
        $statuses = EmployeeStatusModel::all();
        $roles = RoleModel::all();
        $user = $user->get()[0];
        return view('settings.user.show',compact('user','departments','genders','statuses','roles','disabled'));
    }


    public function edit($id){
        $user = User::where('id',$id);
        if(!$user->count()){
            return RedirectHelper::not_found();
        }

        if(isset($_GET['block'])){
            return $this->block_user($user);
        }
        
        //die($user->get());
        $departments = DepartmentModel::all();
        $genders = GenderModel::all();
        $statuses = EmployeeStatusModel::all();
        $roles = RoleModel::all();
        $user = $user->get()[0];
        $users = User::all();
        return view('settings.user.edit',compact('user','departments','genders','statuses','roles','users'));
    }

    protected function block_user($user){
        if(!empty($_GET['block'])){
            $block = $_GET['block'];
            if($block){
                $block = 0;
            }else{
                $block = 1;
            }
        }else{
            $block = 1; 
        }
        $user->update(['status' => $block]);
        if($block){
            $sms = __('words.successfull_blocked');
        }else{
            $sms = __('words.successfull_unblocked');
        }
        return RedirectHelper::back_error($sms,__('words.successfully'),'success');
    }

    protected function update($id,Request $request)
    {
        $user = User::where('id',$id);
        if(!$user->count()){
            return RedirectHelper::not_found();
        }
        $data = $request->all();
        if(isset($_GET['attachment'])){
            $name = DownloadHelper::file_upload($request->file('attachment'),'user_attachments');
            if($name != ""){
                $user = UserAttachmentModel::create([
                    'user_id' => $request->user_id,
                    'name' => $request->name,
                    'created_by' => Auth::user()->id,
                    'attachment' => $name,
                ]);
            }else{
                $user = 0;
            }
        }else if(isset($_GET['ids'])){
            $user = $user->update(
                [
                    'employee_no' => $request->employee_no,
                    'pension_no' => $request->pension_no,
                    'national_id' => $request->national_id,
                    'tin_no' => $request->tin_no,
                    'joined_date' => $request->joined_date,
                ]
            );
        }else if(isset($_GET['password'])){
            $user = $user->update(
                [
                    'password' => Hash::make($request->password),
                ]
            );
        }else if(isset($_GET['bank'])){
            $basic = str_replace(',','',$request->basic_salary);
            if(!is_numeric($basic)){
                return RedirectHelper::back_error(__('words.not_numeric'),__('words.failed'),'danger');
            }
            $user = $user->update(
                [
                    'bank_name' => $request->bank_name,
                    'account_name' => $request->account_name,
                    'account_no' => $request->account_no,
                    'basic_salary' => $basic
                ]
            );
        }else{
            $this->validate($request,[
                'first_name' => ['required', 'string', 'max:255'],
                'last_name' => ['required', 'string', 'max:255'],
                'surname' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255'],
                'gender' => ['required', 'string'],
                'department' => ['required', 'string'],
                'status' => ['required', 'string'],
                'role' => ['required', 'string'],
            ]);
            UserUpdateModel::UpdateDetails($request,$id,['first_name' => 'fname','last_name' => 'lname','surname' => 'sname','status'=>'employee_status']);
            $user = $user->update(
                [
                    'fname' => $data['first_name'],
                    'lname' => $data['last_name'],
                    'sname' => $data['surname'],
                    'email' => $data['email'],
                    'phone' => $data['phone'],
                    'dob' => $data['dob'],
                    'post_address' => $data['post_address'],
                    'gender' => $data['gender'],
                    'department_id' => $data['department'],
                    'employee_status' => $data['status'],
                    'roles' => $data['role'],
                    //'password' => Hash::make($data['password']),
                ]
            );
        }
       return RedirectHelper::update_sms($user);
    }

    public function payroll(){
        $users = User::where('employee_status',1)->get();
        foreach($users as $user){
            $payroll = PayrollModel::where('user_id',$user->id)->whereMonth('month',date('m'))->whereYear('month',date('Y'));
            if(!$payroll->count()){
                PayrollModel::create([
                    'basic_salary' => $user->basic_salary,
                    'pension' => CalculationHelper::pension($user->basic_salary),
                    'paye' => CalculationHelper::paye($user->basic_salary),
                    'advance' => CalculationHelper::advance($user->advance()),
                    'loan' => CalculationHelper::month_pay(CalculationHelper::loan($user->id)),
                    'loan_board' => CalculationHelper::month_pay(CalculationHelper::loan($user->id,'board')),
                    //'bft_loan' => CalculationHelper::month_pay(CalculationHelper::loan($user->id,'bft_loan')),
                    'sdl' => CalculationHelper::sdl($user->basic_salary),
                    'user_id' => $user->id,
                    'month' => Carbon::now()->format('Y-m-d'),
                ]);
                echo "created";
            }else{
                $payroll->update([
                    'basic_salary' => $user->basic_salary,
                    'pension' => CalculationHelper::pension($user->basic_salary),
                    'paye' => CalculationHelper::paye($user->basic_salary),
                    'advance' => CalculationHelper::advance($user->advance()),
                    'loan' => CalculationHelper::month_pay(CalculationHelper::loan($user->id)),
                    'loan_board' => CalculationHelper::month_pay(CalculationHelper::loan($user->id,'board')),
                    //'bft_loan' => CalculationHelper::month_pay(CalculationHelper::loan($user->id,'bft_loan')),
                    'sdl' => CalculationHelper::sdl($user->basic_salary),
                    'user_id' => $user->id,
                ]);
                echo "updated";
            }
        }
    }
    
    public function download_past($id){
        if($id == "pspf"){
            return view('settings.user.pspf');
        }else{
            return view('settings.user.wcf');
        }
    }
    
    public function download_past_payslip(){
        $users = User::all();
        return view('settings.user.past_payslip',compact('users'));
    }
}
