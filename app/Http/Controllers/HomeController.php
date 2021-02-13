<?php

namespace App\Http\Controllers;

use App\Models\Money\LoanActivitiesModel;
use App\Models\Money\LoanModel;
use Illuminate\Http\Request;

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
        return view('home',\compact('loans','loan_activities'));
    }
}
