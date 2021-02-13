<?php

namespace App\Models\Auth;

use App\User;
use Illuminate\Database\Eloquent\Model;

class UserAttachmentModel extends Model
{
    //
    protected $table = "user_attachments";
    protected $fillable = ['user_id','created_by','name','attachment'];

    public function users(){
        return $this->belongsTo(User::class,'user_id','id');
    }
    
    public function created_user(){
        return $this->belongsTo(User::class,'created_by','id');
    }
}
