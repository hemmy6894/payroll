<?php

namespace App\Models\Money;

use Illuminate\Database\Eloquent\Model;
use App\User;

class AdvanceSalaryModel extends Model
{
    //
    protected $table = "advance_salaries";
    protected $fillable = [
        'user_id','salary_month','amount','created_by','comment'
    ];

    public function scopeBy_month($query,$user,$month = "",$year = ""){
        if($month == ""){ $month = date('m'); }
        if($year == ""){ $year = date('Y'); }
        return $query->where('user_id',$user)->whereMonth('salary_month',$month)->whereYear('salary_month',$year);
    }
    
    public function users(){
        return $this->belongsTo(User::class,'user_id','id');
    }
    
    public function created_user(){
        return $this->belongsTo(User::class,'created_by','id');
    }
}
