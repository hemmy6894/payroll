<?php

namespace App\Http\Controllers;

use App\Models\Money\LoanActivitiesModel;
use App\Models\Money\LoanModel;
use App\Models\Money\PayrollModel;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $loans = LoanModel::where('state',0)->paginate(10);
        $loan_activities = LoanActivitiesModel::orderBy('created_at','DESC')->paginate(10);

        $dashboards = [
            ['table' => 'Payrolls', 'count' => User::payroll()->count(), 'icon' => 'users', 'link' => route('user.index')],
            ['table' => 'Employees', 'count' => User::allempo()->count(), 'icon' => 'users', 'link' => route('user.index')."?all"],
            ['table' => 'This Month B. Salary', 'count' => \number_format(User::payroll()->get()->sum('basic_salary'),2), 'icon' => 'users'],
        ];
        $charts = [
            "payment_month" => $this->payment_monthly(),
        ];
        return view('home',\compact('loans','loan_activities','charts','dashboards'));
    }

    public function payment_monthly(){
        $day = Carbon::now()->addDays(-31)->format('Y-m-d H:i:s');
        $products = PayrollModel::select(DB::raw('SUM(basic_salary) as basic_salary'),'user_id')->whereDate('created_at','>',$day)
                                                                                                              ->orderBy('basic_salary','DESC')->groupBy('user_id')->limit(10)->get();
        $results = [];
        $lables = [];
        $data = [];
        $data_set = [];
        
        foreach($products as $product){
            $pro = $product->users??null;
            $lables[] = $product->user_id;
            $data[] = (int)$product->basic_salary;
        }
        
       
        $borderColors = ["#dc9208","rgba(0, 194, 146, 0.9)"];
        $backgroundColor = ["#dc9200","rgba(0, 194, 146, 0.5)"];
        $color_interetor = 0;
        
         $data_set[] = [
                        "label" => "Quanitity",
                        "data" => $data,
                        "borderColor" => $borderColors[$color_interetor],
                        // "backgroundColor" => $borderColors[$color_interetor],
                        "borderWidth" => "0"
                    ];
                    
        $report = [
                        "name" => "TOP FAST MOVING ITEMS (In 30 days)",
                        "class" => "col-md-12",
                        "type" => "horizontalBar",
                        "data" => [
                                    "labels" => $lables,
                                    "datasets" => $data_set,
                                    "options" => [
                                            "responsive" => true,
                                            "hover" => [
                                                "mode" => "nearest",
                                                "intersect" => true
                                            ],
                                            "tooltips" => [
                                                "mode" => "index",
                                                "intersect" => false
                                            ]
                                        ]
                            ]
                    ];
        return $report;
        //End of report Sales
    }
}
