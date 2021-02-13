<?php
    namespace App\Excels;

use App\Http\Helpers\DownloadHelper;
use App\Http\Helpers\WhereHelper;
use App\User;
use Illuminate\Contracts\View\View;
    use Maatwebsite\Excel\Concerns\FromView;

    class CSVExport implements FromView{
        private $array;
        public function __construct($array){
                $this->array = $array;
        }
        public function view(): View
        {
            return view('exports.csv', $this->array);
        }
    }
