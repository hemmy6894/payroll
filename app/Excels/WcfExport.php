<?php
    namespace App\Excels;

use App\Http\Helpers\DownloadHelper;
use App\Http\Helpers\WhereHelper;
use App\User;
use Illuminate\Contracts\View\View;
    use Maatwebsite\Excel\Concerns\FromView;

    class WcfExport implements FromView{
        public function view(): View
        {
            $users = User::orderBy('id','ASC');
            $users = WhereHelper::where_array($users,['lname','fname','sname','national_id'],'like');
            if(!isset($_GET['system'])){
                $users->where('employee_status','!=',3);
            }else{
                $users->where('employee_status','=',3);
            }
            if(!isset($_GET['all'])){
                $users->where('employee_status',1);
            }
            $users = DownloadHelper::wcf([
                            __('words.sn'),
                            __('words.name'),
                            __('words.basic_salary'),
                            __('words.pension'),
                        ],
                        $users->get(),
                        "wcf.csv"
                    );
            return view('exports.wcf', [
                'wcfs' => $users
            ]);
        }
    }
