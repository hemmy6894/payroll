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
        $date = Carbon::createFromTimeString($request->month . "-1 0:00:00");
        $year = $date->format('Y');
        $month = $date->format('m');

        return $this->download_payroll(PayrollModel::whereMonth('month',$month)->whereYear('month',$year));
    }

    protected function download_payroll($data){
        return DownloadHelper::payroll(
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
            $data->get(),
            "users.csv",
            'past'
        );
    }
}
