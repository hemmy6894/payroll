<?php

namespace App\Models\Money;

use App\User;
use Illuminate\Database\Eloquent\Model;

class BftLoanModel extends Model
{
     //
     protected $table = "bft_loans";
     protected $fillable = [
         'loan_no','user_id','amount','balance','rate','monthly_payment','created_by','start_at','state'
     ];
 
     public function activities(){
         return $this->hasMany(BftLoanActivityModel::class,'loan_id','id');
     }
 
     public function owned(){
         return $this->belongsTo(User::class,'user_id','id');
     }
 
     public function created_user(){
         return $this->belongsTo(User::class,'created_by','id');
     }
 
     public function scopePayloan($query,$user_id,$comment=""){
         return ModelHelper::payloan($query,$user_id,"bft_loan",$comment);
     }
 
     public function scopeCreateLoan($query,$user_id,$amount,$monthly_pay,$start_at,$rate = 0,$comment=""){
         //return $comment;
         return ModelHelper::createloan($query,$user_id,$amount,$monthly_pay,$start_at,"bft_loan",$rate,$comment);
     }
 
     // TODO
     public function scopeUpdateLoan($query,$user_id,$amount,$monthly_pay,$start_at,$rate = 0){
         //Check how much is already payed, return the loan then re create
         //Or close current loan and create new loan from the current loan
     }
}
