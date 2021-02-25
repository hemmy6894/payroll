<?php

namespace App\Http\Controllers\Money;

use App\Http\Controllers\Controller;
use App\Http\Helpers\DownloadHelper;
use App\Models\Money\PayrollModel;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PayrollController extends Controller
{
    //
    public function download(Request $request){
        $date = Carbon::createFromTimeString($request->month . "-1 00:00:00");
        $year = $date->format('Y');
        $month = $date->format('m');

        if($request->month_to != ""){
            $date2 = Carbon::createFromTimeString($request->month_to . "-28 23:59:59");
            $year2 = $date2->format('Y');
            $month2 = $date2->format('m');
            $payrolls = PayrollModel::whereBetween('month',[$date,$date2])->get()->groupBy('user_id');
            return $this->download_payroll($payrolls,'multiple');
        }
        
        return $this->download_payroll(PayrollModel::whereMonth('month',$month)->whereYear('month',$year)->get());
    }

    protected function download_payroll($data,$type="single"){
        return DownloadHelper::payroll(
            [
                __('words.name'),
                __('words.basic_salary'),
                __('words.pension'),
                __('words.paye'),
                __('words.advance'),
                __('words.loan'),
                __('words.loan_board'),
                __('words.bft_loan_amount'),
                __('words.net_salary'),
                // __('words.sdl'),
                
            ],
            $data,
            "users.csv",
            'past',
            $type
        );
    }
}
