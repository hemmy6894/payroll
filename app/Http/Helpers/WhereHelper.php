<?php

namespace App\Http\Helpers;

class WhereHelper
{
    public static function where_array($query,$array,$sign = "=",$search="search"){
        $where = "";
        if(count($array)){
            if(isset($_GET[$search])){
                if(!empty($_GET[$search])){
                    $search = $_GET[$search];
                    $se = explode(' ',$search);
                    if(count($se)){
                        $search = $se[0];
                    }
                    if($sign == "like"){
                        $query->where($array[0],$sign,'%' .$search . '%');
                    }else{
                        $query->where($array[0],$sign,$search);
                    }
                    unset($array[0]);
                    foreach($array as $ar){
                        if($sign == "like"){
                            $query->orWhere($ar,$sign,'%' .$search . '%');
                        }else{
                            $query->orWhere($ar,$sign,$search);
                        }
                    }
                }
            }
        }
        return $query;
    }
}