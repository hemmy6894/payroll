<?php
    namespace App\Excels;

use App\Http\Helpers\DownloadHelper;
use App\Http\Helpers\WhereHelper;
use App\User;
use Illuminate\Contracts\View\View;
    use Maatwebsite\Excel\Concerns\FromView;

    class PspfExport implements FromView{
        public function view(): View
        {
            $users = User::orderBy('id','ASC');
            $users = WhereHelper::where_array($users,['lname','fname','sname','national_id'],'like');
            if(!isset($_GET['system'])){
                $users->where('employee_status','!=',3);
            }else{
                $users->where('employee_status','=',3);
            }
            $users = DownloadHelper::pspf(
                [
                    __('words.sn'),
                    __('words.name'),
                    __('words.basic_salary'),
                    __('words.member_amount'),
                    __('words.employee_amount'),
                    __('words.total_contribution'),
                ],
                $users->get(),
                "pspf.csv"
            );
            
            return view('exports.pspf', [
                'pspfs' => $users
            ]);
        }
    }
