<?php

namespace App;

use App\Models\Auth\DepartmentModel;
use App\Models\Auth\EmployeeStatusModel;
use App\Models\Auth\GenderModel;
use App\Models\Auth\RoleModel;
use App\Models\Money\AdvanceSalaryModel;
use App\Models\Money\LoanBoardModel;
use App\Models\Money\LoanModel;
use App\Models\Money\BftLoanModel;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Auth\UserAttachmentModel;
use App\Models\Helpers\UserUpdateModel;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'fname', 'lname', 'sname',
        'employee_no', 'pension_no', 'national_id',
        'email', 'email_verified_at', 'password',
        'dob', 'gender', 'phone','post_address',
        'basic_salary','department_id','roles','employee_status',
        'bank_name','account_name','account_no'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    
    public function getFullNameAttribute()
    {
        return "{$this->fname} {$this->lname} {$this->sname}";
    }

    public function departments(){
        return $this->belongsTo(DepartmentModel::class,'department_id','id');
    }
    
    public function attachments(){
        return $this->hasMany(UserAttachmentModel::class,'user_id','id');
    }

    public function t_roles(){
        return $this->belongsTo(RoleModel::class,'roles','id');
    }

    public function genders(){
        return $this->belongsTo(GenderModel::class,'gender','id');
    }

    public function t_status(){
        return $this->belongsTo(EmployeeStatusModel::class,'employee_status','id');
    }

    public function advance(){
        return $this->hasMany(AdvanceSalaryModel::class,'user_id','id');
    }

    public function active_loan(){
        return $this->hasMany(LoanModel::class,'user_id','id')->where('state',0);
    }
    
    public function active_bft_loan(){
        return $this->hasMany(BftLoanModel::class,'user_id','id')->where('state',0);
    }

    public function loans(){
        return $this->hasMany(LoanModel::class,'user_id','id');
    }

    public function loan_boards(){
        return $this->hasMany(LoanBoardModel::class,'user_id','id');
    }

    public function active_loan_board(){
        return $this->hasMany(LoanBoardModel::class,'user_id','id')->where('state',0);
    }
    
    public function updates(){
        return $this->hasMany(UserUpdateModel::class,'user_id','id');
    }
    
}
