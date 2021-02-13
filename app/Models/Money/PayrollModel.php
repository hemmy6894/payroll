<?php

namespace App\Models\Money;

use App\User;
use Illuminate\Database\Eloquent\Model;

class PayrollModel extends Model
{
    //
    protected $table = "payrolls";
    protected $fillable = [
        'basic_salary','pension','paye','advance','loan','loan_board','sdl','user_id','month','bft_loan'
    ];

    public function users(){
        return $this->belongsTo(User::class,'user_id','id');
    }
}
