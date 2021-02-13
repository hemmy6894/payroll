<?php

namespace App\Http\Controllers\Money;

use App\Http\Controllers\Controller;
use App\Http\Helpers\CalculationHelper;
use App\Http\Helpers\DownloadHelper;
use App\Http\Helpers\PaginateHelper;
use App\Http\Helpers\RedirectHelper;
use App\Http\Helpers\WhereHelper;
use App\Models\Money\BftLoanModel;
use App\Models\Money\LoanBoardModel;
use App\Models\Money\LoanModel;
use App\Models\Money\BftLoanActivityModel;
use App\Models\Money\LoanBoardActivitiesModel as LoanBoardActivityModel;
use App\Models\Money\LoanActivitiesModel as LoanActivityModel;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class LoanController extends Controller
{
    protected $loanmodel = LoanModel::class;
    protected $key_model = "activities";
    protected $key_download_activity = "?download_activity";
    public function __construct()
    {
        if(isset($_GET['loan_board'])){
            $this->loanmodel = LoanBoardModel::class;
            $this->key_model = "activities";
            $this->key_download_activity = "?loan_board&download_activity";
        }
        
        if(isset($_GET['bft_loan'])){
            $this->loanmodel = BftLoanModel::class;
            $this->key_model = "activities";
            $this->key_download_activity = "?bft_loan&download_activity";
        }
    }

    public function payment(){
        $users = User::where('employee_status',1)->get();
        foreach($users as $user){
            if($this->loanmodel::payloan($user->id)){
                echo $user->fname . " " . $user->sname . "<br />";
            }
        }
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $loans = $this->loanmodel::orderBy('id','DESC')->where('state',0);
        $loans = WhereHelper::where_array($loans,['']);
        
        $users = User::orderBy('id','ASC');
        if(!isset($_GET['system'])){
            $users->where('employee_status','!=',3);
        }else{
            $users->where('employee_status','=',3);
        }
        
        if(isset($_GET['download'])){
            return $this->download($loans);
        }
        if(isset($_GET['download_activity'])){
            return $this->download_activity($loans);
        }
        $loans = $loans->paginate(PaginateHelper::per_page());
        $users = $users->paginate(PaginateHelper::per_page());
        $download_link = RedirectHelper::donwnload_url(); 
        return view('loan.index',\compact('loans','users','download_link'));
    }

    protected function download($users){
        return DownloadHelper::csv(
            [
                __('words.loan_no'),
                __('words.employee'),
                __('words.amount'),
                __('words.balance'),
                __('words.monthly_payment'),
                __('words.created_by'),
                __('words.created_date'),
            ],
            [
                'loan_no',
                ['owned','fname','lname','sname'],
                'amount',
                'balance',
                'monthly_payment',
                ['created_user','fname','lname','sname'],
                'created_at',
            ],
            $users->get(),
            "loans.csv"
        );
    }

    protected function download_activity($users){
        return DownloadHelper::loan(
            [
                __('words.loan_no'),
                __('words.created_date'),
                __('words.credit'),
                __('words.debit'),
                __('words.balance'),
                __('words.comment'),
                __('words.created_by'),
            ],
            $users,
            "loan_activities.csv"
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
        $user_id = CalculationHelper::get('user',"");
        $user = User::where('id',$user_id);
        if(!$user->count()){
            return RedirectHelper::not_found("");
        }
        $user = $user->get()[0];
        return view('loan.create',\compact('user_id','user'));
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
            'monthly_pay' => 'required',
            'amount' => 'required',
            'user_id' => 'required',
            'comment' => ['required','max:400'],
        ]);

        if($request->start_at == "next"){
            $request_salary_month = Carbon::now()->addMonth()->format('Y-m-d');
        }else{
            $request_salary_month = Carbon::now()->format('Y-m-d');
        }
        
        if(!User::where('employee_status',1)->where('id',$request->user_id)->count()){
            return RedirectHelper::create_sms(0,'loan.index',"User not in post");
        }
        
        $loan = $this->loanmodel::createLoan(
            $request->user_id,
            $request->amount,
            $request->monthly_pay,
            $request_salary_month,
            0,
            $request->comment,
        );
        return RedirectHelper::create_sms($loan,'loan.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Auth\$this->loanmodel  $loanModel
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $loan = $this->loanmodel::where('user_id',$id)->orderBy('created_at','DESC');
        if(!$loan->count()){
            return RedirectHelper::not_found();
        }

        $disabled = "disabled";
        $loan = $loan->get()[0];
        $user = $loan->user_id;
        $loans = $this->loanmodel::where('user_id',$user)->orderBy('created_at','ASC')->get();
        //return $loans;
        $download_link = route('loan.index') . $this->key_download_activity . "=" . $user;
        return view('loan.edit',compact('loan','loans','disabled','download_link'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Auth\$this->loanmodel  $loanModel
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $loan = $this->loanmodel::where('id',$id);
        if(!$loan->count()){
            return RedirectHelper::not_found();
        }
        if(isset($_GET['block'])){
            return RedirectHelper::block_user($loan);
        }
        $loan = $loan->get()[0];
        return view('loan.edit',compact('loan'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Auth\$this->loanmodel  $loanModel
     * @return \Illuminate\Http\Response
     */
    public function update($id,Request $request)
    {
        //
        $loan = $this->loanmodel::where('id',$id);
        if(!$loan->count()){
            return RedirectHelper::not_found();
        }
        $dept = $loan->update([
            'name' => $request->name,
        ]);
        return RedirectHelper::update_sms($dept,'loan.index');
    }
    
    public function filter_by_date(){
        return view('loan.filter_date');
    }
    
    public function download_by_date(Request $request){
        $date = [];
        $d_come = $request->date ?? date('Y-m');
        $dc = Carbon::createFromTimeString($d_come . "-01 00:00:00");
        
        $date[] = $from = $dc->addDays(-5)->format('Y-m') . "-24";
        $date[] = $to = $d_come . "-24";
        $loans = [
                "Staff Loan" => LoanActivityModel::class,
                "Bft Loan" => BftLoanActivityModel::class,
                "Loan Board" => LoanBoardActivityModel::class,
            ];
            
        $all = "Loan From, $from, - $to\n";
        $all .= "";
        foreach($loans as $key => $loan){
            $all .= $key . "\n";
            $all .= "Serial No,Name,Payroll No,Currency,Opening Balance,Recovered Amount,Closing Balance,State\n";
            $i = 1;
            foreach($loan::whereBetween('created_at',$date)->get() as $l){
                $state = @$l->loans->state ? 'paid' : 'on progress';
                $all .= $i++ . ",".  @$l->user->full_name . "," . @$l->user->employee_no . ",TZS," . @$l->balance . ","  . @$l->loans->monthly_payment . "," . @$l->balance . "," .  $state . "\n";
            }
            $all .= "\n";
        }
        
        return response()->download_csv($all,"file_1.csv");
        echo $all;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Auth\$this->loanmodel  $loanModel
     * @return \Illuminate\Http\Response
     */
    public function destroy(LoanModel $loanModel)
    {
        //
    }
}
