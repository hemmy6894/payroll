<?php

namespace App\Http\Helpers;

use App\Models\Helpers\VariableModel;
use App\Models\Money\LoanBoardModel;
use App\Models\Money\LoanModel;
use App\Models\Money\BftLoanModel;

class CalculationHelper
{
    protected static $pension_percent = 10; //
    protected static $sdl_percent = 5; //
    protected static $paye_values = array(
                                            array('min' => 0, 'max' => 270000, 'min_tax' => 0, 'percent' => 0),
                                            array('min' => 270000, 'max' => 520000, 'min_tax' => 0, 'percent' => 9),
                                            array('min' => 520000, 'max' => 760000, 'min_tax' => 22500, 'percent' => 20),
                                            array('min' => 760000, 'max' => 1000000, 'min_tax' => 70500, 'percent' => 25),
                                            array('min' => 1000000, 'max' => 9999999999, 'min_tax' => 130500, 'percent' => 30),
    );


    public static function pension($basic_salary){
        if(\is_numeric($basic_salary))
            $pension_percent = VariableModel::pension_percent(CalculationHelper::$pension_percent);
            // die($pension_percent);
            if(!\is_numeric($pension_percent)){
                $pension_percent =  CalculationHelper::$pension_percent;
            }
            return ($pension_percent / 100) * $basic_salary;
        return 0;
    }

    public static function sdl($basic_salary){
        if(\is_numeric($basic_salary))
            $sdl_percent = VariableModel::sdl_percent(CalculationHelper::$sdl_percent);
            if(!\is_numeric($sdl_percent)){
                $sdl_percent =  CalculationHelper::$sdl_percent;
            }
            return ($sdl_percent / 100) * $basic_salary;
        return 0;
    }

    //PAYE= (BS - NSSSF)*%(Exceeding amount) + Min amount
    public static function paye($basic_salary){
        $pension = CalculationHelper::pension($basic_salary);
        $net_one = $basic_salary - $pension;
        $exceeding = 0;
        $min_aount = 0;
        foreach(CalculationHelper::$paye_values as $pay){
            if($pay['min'] <= $net_one && $net_one < $pay['max']){
                $exceeding = ($net_one - $pay['min']) * $pay['percent'] / 100;
                $min_aount = $pay['min_tax'];
            }
        }

        return $exceeding + $min_aount;
    }

    public static function advance($advance){
        $advance->whereMonth('salary_month',CalculationHelper::get('month',date('m')))->whereYear('salary_month',CalculationHelper::get('year',date('Y')));
        if($advance->count()){
            return $advance->get()[0]->amount;
        }
        return 0;
    }

    public static function loan($user_id,$type = "loan",$state = "no"){
        if($type == "loan"){
            $loanmodel = LoanModel::class;
        }
        else if($type == "bft_loan"){
            $loanmodel = BftLoanModel::class;
        }
        else{
            $loanmodel = LoanBoardModel::class;
        }

        $loan = $loanmodel::where('user_id',$user_id);
        if($state == "no"){
            $loan->where('state',0);
        }
        if($loan->count()){
            return $loan->get()[0];
        }
        return json_decode(collect(['amount' => 0,'balance' => 0,'monthly_payment' => 0,'loan_no' => $user_id,'no_loan' => true])->toJson());
    }

    public static function month_pay($loan){
        if($loan->balance < $loan->monthly_payment){
            return $loan->balance;
        }else{
            return $loan->monthly_payment;
        }
    }

    public static function net_salary($adds = [], $subs = []){
        $total = 0;
        if(\is_array($adds)){
            foreach($adds as $add){
                if(\is_numeric($add))
                    $total += $add;
            }
        }
        if(\is_array($subs)){
            foreach($subs as $sub){
                if(\is_numeric($sub))
                    $total -= $sub;
            }
        }
        return $total;
    }

    public static function get($key,$value=""){
        if(isset($_GET[$key])){
            if(!empty($_GET[$key])){
                return $_GET[$key];
            }
        }
        return $value;
    }

    public static function generate_link($words,$fetch,$separator,$link_name,$args,$link_lable = ""){
        return RedirectHelper::generate_link($words,$fetch,$separator,$link_name,$args,$link_lable);
    }
    
    public static function word_cut($word,$num = 100){
        if(strlen($word) > $num){
            return substr($word,0,$num) . " ...";
        }
        return $word;
    }

    public static function debit_credit($money,$d = "credit"){
        if(\is_numeric($money)){
            if($money < 0){
                $money = $money * -1;
                if($d == "debit"){
                    return $money;
                }
            }else{
                if($d == "credit"){
                    return $money;
                }
            }
        }
        return "dc";
    }
}