<?php

namespace App\Models\Money;

use App\User;
use Illuminate\Database\Eloquent\Model;

class LoanActivitiesModel extends Model
{
    //
    protected $table = "loan_activities";
    protected $fillable = [
        'loan_id','user_id','amount','balance','comment','type'
    ];

    public function loans(){
        return $this->belongsTo(LoanModel::class,'loan_id','id');
    }

    public function user(){
        return $this->belongsTo(User::class,'user_id','id');
    }

    public function scopeActivity($query,$loan_id,$amount,$balance,$comment,$type,$comment2){
       ModelHelper::activity($query,$loan_id,$amount,$balance,$comment,$type,$comment2);
    }
}
