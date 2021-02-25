<?php

namespace App\Http\Helpers;

use App\Models\Money\LoanBoardModel;
use App\Models\Money\LoanModel;
use Carbon\Carbon;
use App\Models\Money\PayrollModel;
use Excel;
use App\Excels\CSVExport;

class DownloadHelper
{
    public static $company_name = "Rosper Schools Payroll ";
    
    public static function csv($haeder,$field,$array,$name,$data_header=[]){
        $name = Carbon::now()->format('YmdHms') . "__" . $name . ".xlsx";
        return Excel::download(new CSVExport(compact('haeder','field','array','name','data_header')), $name);
        $r = "";
        if(count($data_header)){
            $r .= implode(",",$data_header) . "\n";
        }
        $r .= implode(",",$haeder) . "\n";
        foreach($array as $arr){
            foreach($field as $f){
                if(\is_array($f)){
                    $f0 = $f[0];
                    unset($f[0]);
                    $temp = "";
                    foreach($f as $s){
                        $temp .= " " . $arr->$f0->$s;
                    }
                    $r .= $temp . ",";
                }else{
                    $fs = \explode(",",$f);
                    $d = "";
                    foreach($fs as $f){
                        $d .= $arr->$f . " ";
                    }
                    $r .= $d. ",";
                }
            }
            $r .= "\n";
            
        }
        $name = Carbon::now()->format('YmdHms') . "__" . $name;
        return response()->download_csv($r,$name);
    }

    public static function user($haeder,$users,$name,$header_null=[]){
        $new_user = [];
        $new_user_total = [
                'name' => "TOTAL",
                //'email' => $user->email,
                'basic_salary' => 0,
                'pension' => 0,
                'paye' => 0,
                'advance' => 0,
                'loan' => 0,
                'loan_board' => 0,
                'loan_bft' => 0,
                'net_salary' => 0,
                //'department' => $user->departments->name,
                //'gender' => $user->genders->name,
                // 'sdl' => 0,
            ];
        foreach($users as $user){
            $pension = CalculationHelper::pension($user->basic_salary);
            // $sdl = CalculationHelper::sdl($user->basic_salary);
            $paye = CalculationHelper::paye($user->basic_salary);
            $advance = CalculationHelper::advance($user->advance());
            $loan = CalculationHelper::month_pay(CalculationHelper::loan($user->id));
            $loan_board = CalculationHelper::month_pay(CalculationHelper::loan($user->id,'board'));
            $loan_bft =   CalculationHelper::month_pay(CalculationHelper::loan($user->id,'bft_loan')); 
            $net_salary = CalculationHelper::net_salary([$user->basic_salary],[$pension,$paye,$advance,$loan,$loan_board,$loan_bft]); 
            
            $new_user_total['basic_salary'] += $user->basic_salary;
            $new_user_total['pension'] += $pension;
            $new_user_total['paye'] += $paye;
            $new_user_total['advance'] += $advance;
            $new_user_total['loan'] += $loan;
            $new_user_total['loan_board'] += $loan_board;
            $new_user_total['loan_bft'] += $loan_bft;
            $new_user_total['net_salary'] += $net_salary;
            // $new_user_total['sdl'] += $sdl;
            $new_user[] = [
                'name' => $user->fname . " " . $user->lname . " " . $user->sname,
                //'email' => $user->email,
                'basic_salary' => DownloadHelper::money($user->basic_salary),
                'pension' => DownloadHelper::money($pension),
                'paye' => DownloadHelper::money($paye),
                'advance' => DownloadHelper::money($advance),
                'loan' => DownloadHelper::money($loan),
                'loan_board' => DownloadHelper::money($loan_board),
                'loan_bft' => DownloadHelper::money($loan_bft),
                'net_salary' => DownloadHelper::money($net_salary),
                //'department' => $user->departments->name,
                //'gender' => $user->genders->name,
                // 'sdl' => DownloadHelper::money($sdl),
            ];
        }
        $new_user_total['basic_salary'] = DownloadHelper::money($new_user_total['basic_salary']);
        $new_user_total['pension'] = DownloadHelper::money($new_user_total['pension']);
        $new_user_total['paye'] = DownloadHelper::money($new_user_total['paye']);
        $new_user_total['advance'] = DownloadHelper::money($new_user_total['advance']);
        $new_user_total['loan'] = DownloadHelper::money($new_user_total['loan']);
        $new_user_total['loan_board'] = DownloadHelper::money($new_user_total['loan_board']);
        $new_user_total['loan_bft'] = DownloadHelper::money($new_user_total['loan_bft']);
        $new_user_total['net_salary'] = DownloadHelper::money($new_user_total['net_salary']);
        // $new_user_total['sdl'] = DownloadHelper::money($new_user_total['sdl']);
        $new_user[] = $new_user_total;
        return DownloadHelper::csv($haeder,['name','basic_salary','pension','paye','advance','loan','loan_board','loan_bft','net_salary'],json_decode(collect($new_user)->toJson()),$name,$header_null);
    }

    public static function file_upload($file,$location,$i = 0,$type="noraml"){
        $file_name = "";
        if($file->isValid()){
            $extention = $file->getClientOriginalExtension();
            $file_name = Carbon::now()->format('YmdHis')."PIC$i".".".$extention;
            $file->move($location,$file_name);
            $file_name = "$location/".$file_name;
        }
        return $file_name;
    }

    public static function payroll($haeder,$users,$file_name,$normal = "normal",$type="single"){
        if(request()->month){
            $date = Carbon::createFromTimeString(request()->month . "-1 0:00:00");
            $document_header = [DownloadHelper::$company_name . " " . $date->format('M, Y')];
        }else{
            $document_header = [DownloadHelper::$company_name . " " . date('M, Y')];
        }
        $new_user_total = [
                'name' => "TOTAL",
                //'email' => $user->email,
                'basic_salary' => 0,
                'pension' => 0,
                'paye' => 0,
                'advance' => 0,
                'loan' => 0,
                'loan_board' => 0,
                'loan_bft' => 0,
                'net_salary' => 0,
                //'department' => $user->departments->name,
                //'gender' => $user->genders->name,
                // 'sdl' => 0,
            ];
        $new_user = [];
        foreach($users as $user){
            if($normal == "normal"){
                $basic_salary = $user->basic_salary;
                $pension = CalculationHelper::pension($user->basic_salary);
                // $sdl = CalculationHelper::sdl($user->basic_salary);
                $paye = CalculationHelper::paye($user->basic_salary);
                $advance = CalculationHelper::advance($user->advance());
                $loan = CalculationHelper::month_pay(CalculationHelper::loan($user->id));
                $loan_board = CalculationHelper::month_pay(CalculationHelper::loan($user->id,'board'));
                $loan_bft = CalculationHelper::month_pay(CalculationHelper::loan($user->id,'loan_bft'));
                $net_salary = CalculationHelper::net_salary([$user->basic_salary],[$pension,$paye,$advance,$loan,$loan_board,$loan_bft]);
                $name  = $user->fname . " " . $user->lname . " " . $user->sname;
            }else{
                
                if($type == "single"){
                    $basic_salary = $user->basic_salary;
                    $pension = $user->pension;
                    // $sdl = $user->sdl;
                    $paye = $user->paye;
                    $advance = $user->advance;
                    $loan = $user->loan;
                    $loan_board = $user->loan_board;
                    $loan_bft = $user->bft_loan;
                   $name  = $user->users->fname . " " . $user->users->lname . " " . $user->users->sname;
                }else{
                    $basic_salary = 0;
                    $pension = 0;
                    // $sdl = 0;
                    $paye = 0;
                    $advance = 0;
                    $loan = 0;
                    $loan_board = 0;
                    $loan_bft = 0;
                    $i = 0;
                    foreach($user as $us){
                        if(!$i){
                            $name  = $us->users->fname . " " . $us->users->lname . " " . $us->users->sname;
                        }
                        $basic_salary += $us->basic_salary;
                        $pension += $us->pension;
                        // $sdl += $us->sdl;
                        $paye += $us->paye;
                        $advance += $us->advance;
                        $loan += $us->loan;
                        $loan_board += $us->loan_board;
                        $loan_bft += $us->bft_loan;
                        $i++;
                    }
                }
                $net_salary = CalculationHelper::net_salary([$basic_salary],[$pension,$paye,$advance,$loan,$loan_board,$loan_bft]);
            }
            $new_user[] = [
                'name' => $name,
                //'email' => $user->email,
                'basic_salary' => DownloadHelper::money($basic_salary),
                'pension' => DownloadHelper::money($pension),
                'paye' => DownloadHelper::money($paye),
                'advance' => DownloadHelper::money($advance),
                'loan' => DownloadHelper::money($loan),
                'loan_board' => DownloadHelper::money($loan_board),
                'loan_bft' => DownloadHelper::money($loan_bft),
                'net_salary' => DownloadHelper::money($net_salary),
                //'department' => $user->departments->name,
                //'gender' => $user->genders->name,
                // 'sdl' => DownloadHelper::money($sdl),
            ];
            $new_user_total['basic_salary'] += $basic_salary;
            $new_user_total['pension'] += $pension;
            $new_user_total['paye'] += $paye;
            $new_user_total['advance'] += $advance;
            $new_user_total['loan'] += $loan;
            $new_user_total['loan_board'] += $loan_board;
            $new_user_total['loan_bft'] += $loan_bft;
            $new_user_total['net_salary'] += $net_salary;
            // $new_user_total['sdl'] += $sdl;
        }
        $new_user_total['basic_salary'] = DownloadHelper::money($new_user_total['basic_salary']);
        $new_user_total['pension'] = DownloadHelper::money($new_user_total['pension']);
        $new_user_total['paye'] = DownloadHelper::money($new_user_total['paye']);
        $new_user_total['advance'] = DownloadHelper::money($new_user_total['advance']);
        $new_user_total['loan'] = DownloadHelper::money($new_user_total['loan']);
        $new_user_total['loan_board'] = DownloadHelper::money($new_user_total['loan_board']);
        $new_user_total['loan_bft'] = DownloadHelper::money($new_user_total['loan_bft']);
        $new_user_total['net_salary'] = DownloadHelper::money($new_user_total['net_salary']);
        // $new_user_total['sdl'] = DownloadHelper::money($new_user_total['sdl']);
        $new_user[] = $new_user_total;
        return DownloadHelper::csv($haeder,['name','basic_salary','pension','paye','advance','loan','loan_board','loan_bft','net_salary'],json_decode(collect($new_user)->toJson()),$file_name,$document_header);
    }

    public static function wcf($haeder,$users,$name){
        $new_user = [];
        $i = 1;
        if(!empty($_GET['download_wcf'])){
            $wcf = $_GET['download_wcf'];
            $date = Carbon::createFromTimeString($wcf . "-1 0:00:00");
            $year = $date->format('Y');
            $month = $date->format('m');
            $users = PayrollModel::whereMonth('month',$month)->whereYear('month',$year)->get();
        }
        foreach($users as $user){
            if(!empty($_GET['download_wcf'])){
                $name_ = $user->users->full_name;
                $employee_no = $user->users->employee_no;
                $pension_no = $user->users->pension_no;
            }else{
                $name_ = $user->full_name;
                $employee_no = $user->employee_no;
                $pension_no = $user->pension_no;
            }
            $pension = CalculationHelper::pension($user->basic_salary);
            $new_user[] = [
                'sn' => $i++,
                'name' => $name_,
                'basic_salary' => DownloadHelper::money($user->basic_salary),
                'pension' => DownloadHelper::money($pension),
                'contribution_no' => $pension_no,
                'employee_no' => $employee_no,
            ];
        }
        return json_decode(collect($new_user)->toJson());
        return DownloadHelper::csv($haeder,
                [
                    'sn',
                    'name',
                    'basic_salary',
                    'pension',
                ]
            ,json_decode(collect($new_user)->toJson()),$name);
    }

    public static function pspf($haeder,$users,$name){
        $new_user = [];
        $i = 1;
        if(!empty($_GET['download_pspf'])){
            $pspf = $_GET['download_pspf'];
            $date = Carbon::createFromTimeString($pspf . "-1 0:00:00");
            $year = $date->format('Y');
            $month = $date->format('m');
            $users = PayrollModel::whereMonth('month',$month)->whereYear('month',$year)->get();
        }
        foreach($users as $user){
            $pension = CalculationHelper::pension($user->basic_salary);
            if(!empty($_GET['download_pspf'])){
                $name_ = $user->users->full_name;
                $employee_no = $user->users->employee_no;
                $pension_no = $user->users->pension_no;
                $nida = $user->users->national_id;
            }else{
                $name_ = $user->full_name;
                $employee_no = $user->employee_no;
                $pension_no = $user->pension_no;
                $nida = $user->national_id;
            }
            $new_user[] = [
                'sn' => $i++,
                'name' => $name_,
                'basic_salary' => DownloadHelper::money($user->basic_salary),
                'pension' => DownloadHelper::money($pension),
                'pension_c' => DownloadHelper::money($pension),
                'pension_t' => DownloadHelper::money($pension * 2),
                'contribution_no' => $pension_no,
                'employee_no' => $employee_no,
                'national_id' => $nida,
            ];
        }
        return json_decode(collect($new_user)->toJson());
        return DownloadHelper::csv($haeder,
                [
                    'sn',
                    'name',
                    'basic_salary',
                    'pension',
                    'pension_c',
                    'pension_t',
                    'contribution_no',
                    'employee_no',
                    'national_id'
                ]
            ,json_decode(collect($new_user)->toJson()),$name);
    }

    protected static $loanmodel = LoanModel::class; 
    public static function loan($haeder,$users,$name){
        $new_user = [];
        if(!empty($_GET['download_activity'])){
            //return $users = $users->where('user_id',$_GET['download_activity'])->get();
            //if($users->count()){
                if(isset($_GET['loan_board'])){
                    DownloadHelper::$loanmodel = LoanBoardModel::class;
                }
                // $activities = $users->get()[0];
                // $user = $activities->user_id;
                $loans = DownloadHelper::$loanmodel::where('user_id',$_GET['download_activity'])->orderBy('created_at','ASC')->get();
                foreach($loans as $loan){
                    foreach($loan->activities as $activity){
                        $new_user[] = [
                            'loan_no' => $loan->loan_no,
                            'created_at' => $activity->created_at,
                            'credit' => DownloadHelper::money(CalculationHelper::debit_credit($activity->amount)),
                            'debit' => DownloadHelper::money(CalculationHelper::debit_credit($activity->amount,'debit')),
                            'balance' => DownloadHelper::money($activity->balance),
                            'comment' => $activity->comment,
                        ];
                    }
                }
            //}
        }
        return DownloadHelper::csv($haeder,['loan_no','created_at','credit','debit','balance','comment'],json_decode(collect($new_user)->toJson()),$name);
    }

    public static function money($money){
        if(\is_numeric($money)){
            return \number_format($money,2,'.',',');
            //return DownloadHelper::qouting($n);
        }
        if($money == "dc"){
            return "";
        }
        return "0.00";
    }
}