<?php

namespace App\Models\Helpers;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Models\Auth\EmployeeStatusModel;
class UserUpdateModel extends Model
{
    protected $table = "user_updates";
    protected $fillable = ['user_id','created_by','body'];
    
    public function scopeUpdateDetails($query,$request,$user_id,$arrs = []){
        $users = User::where('id',$user_id);
        //dd($request->all());
        if($users->count()){
            $user = $users->get()[0];
            foreach($arrs as $val => $arr){
                if($user->$arr != $request->$val){
                    UserUpdateModel::create([
                        'body' => "$val From " . $this->status($user->$arr,$val) . " to " . $this->status($request->$val,$val),
                        'created_by' => auth()->user()->id,
                        'user_id' => $user_id
                    ]);
                }
            }
        }
    }
    
    public function status($id,$type){
        if($type == 'status'){
            $emp = EmployeeStatusModel::where('id',$id);
            if($emp->count()){
                return $emp->get()[0]->name;
            }
        }
        return $id;
    }
    
    public function user(){
        return $this->belongsTo(User::class,'user_id','id');
    }
    
    public function created_user(){
        return $this->belongsTo(User::class,'created_by','id');
    }
}