<?php

namespace App\Models\Money;

use Illuminate\Support\Facades\Auth;
use App\Models\Money\LoanModel;
use App\Models\Money\LoanActivitiesModel;
use App\Models\Money\LoanBoardActivitiesModel;
use App\Models\Money\LoanBoardModel;
use App\Models\Money\BftLoanModel;
use App\Models\Money\BftLoanActivityModel;
use Carbon\Carbon;

class ModelHelper
{
    public static function payloan($query,$user_id,$loan = "loan",$comment=""){
        if($loan == "loan"){
            $activities = LoanActivitiesModel::class;
            $loanModel = LoanModel::class;
        }else if($loan == "bft_loan"){
            $activities = BftLoanActivityModel::class;
            $loanModel = BftLoanModel::class;
        }else{
            $activities = LoanBoardActivitiesModel::class;
            $loanModel = LoanBoardModel::class;
        }

        $payed = 0;
        //if(Auth::check()){
            $loan = $query->where('user_id',$user_id)->where('state',0);
            if($loan->count()){
                $loan = $loan->get()[0];
                $amount = $loan->monthly_payment;
                ///Eter time checking
                $time = Carbon::now();
                if(strlen($loan->start_at) == 10){
                    $time2 = Carbon::createFromTimeString($loan->start_at . " 00:00:00");
                    if($time2->greaterThan($time)){
                        return false;
                    }
                }
                if($loan->balance >= $amount){
                    $payed = (-1) * $amount;
                    $balance = $loan->balance - $amount;
                }else{
                    $payed = (-1) * $loan->balance;
                    $balance = 0;
                }
                $loan->increment('balance',$payed);

                if($balance == 0){
                    $loanModel::where('id',$loan->id)->update(['state' => 1]);
                    $activities::activity($loan->id,$payed,$balance,"Laon payed successfully!!","closed",$comment);
                }else{
                    $activities::activity($loan->id,$payed,$balance,"payed $payed","payed",$comment);
                }
            }
        //}
        return $payed;
    }


    public static function createloan($query,$user_id,$amount,$monthly_pay,$start_at,$loan = "loan",$rate = 0,$comment = ""){
        if($loan == "loan"){
            $activities = LoanActivitiesModel::class;
            $loanModel = LoanModel::class;
            $LN = "RLN";
        }else if($loan == "bft_loan"){
            $activities = BftLoanActivityModel::class;
            $loanModel = BftLoanModel::class;
            $LN = "RFLN";
        }else{
            $activities = LoanBoardActivitiesModel::class;
            $loanModel = LoanBoardModel::class;
            $LN = "RLBN";
        }
        $craeted = false;
        if(Auth::check()){
            $loan = $query->where('user_id',$user_id)->where('state',0);
            $arry_loans = [];
            if($loan->count()){
                $loans = $loan->get()[0];
                $balance = $loans->balance + $amount;
                // foreach($loans as $loan){
                //     $arry_loans[] = ['id' => $loan->id,'balance' => $loan->balance,'no' => $loan->loan_no];
                // }
                $loan->increment('amount',$amount);
                $loan->increment('balance',$amount);
                $loan->update(['monthly_payment' => $monthly_pay]);
                $activities::activity($loans->id,$amount,$balance,"loan toped up with amount of $amount","topedup",$comment);
                return true;
            }

            $loan = $loanModel::create([
                'loan_no' => Carbon::now()->format('YmdHis'),
                'user_id' => $user_id,
                'amount' => $amount,
                'balance' => $amount,
                'rate' => $rate,
                'monthly_payment' => $monthly_pay,
                'created_by' => Auth::user()->id,
                'state' => 0,
                'start_at' => $start_at,
            ]);
            if($loan->wasRecentlyCreated){
                $activities::activity($loan->id,$amount,$amount,"created with amount of $amount","created",$comment);
                $id = $loan->id;
                $nu = 1000000 + $id;
                $loanModel::where('id',$id)->update(['loan_no' => "$LN" . $nu]);
                $craeted = true;
                // foreach($arry_loans as $passed){
                //     $b = $passed['balance'];
                //     $n = $passed['no'];
                //     $activities::activity($passed['id'],$passed['balance'],$passed['balance'],"loan loan::$n cloased with balance of $b  and shifted to loan::$LN$nu","topedup");
                //     $loanModel::where('id',$id)->increment('balance',$b);
                //     $loanModel::where('id',$passed['id'])->update(['state' => 1]);
                //     $t = $loan->balance + $b;
                //     $activities::activity($loan->id,$b,$t,"loan loan::$LN$nu updated with balance of $b  from loan::$n","updated");
                // }
            }
        }
        return $craeted;
    }

    public static function activity($query,$loan_id,$amount,$balance,$comment,$type,$comment2 =""){
        $user = 5;
        if(Auth::check()){
            $user = Auth::user()->id;
        }
        $query->create([
            'loan_id' => $loan_id,
            'user_id' => $user,
            'amount' => $amount,
            'balance' => $balance,
            'type' => $type,
            'comment' => $comment . "<br />" . $comment2,
        ]);
    }
}