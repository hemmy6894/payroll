<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/payloan', 'Money\LoanController@payment')->name('payloan');
Route::get('/payroll_pay', 'Auth\RegisterController@payroll')->name('payroll');
    
Auth::routes(['register' => false]);

Route::middleware(
        [
            'auth',
            'blocked'
        ]
    )->group(function(){
    Route::get('/home', 'HomeController@index')->name('home');
    // Route::post('/register_user', 'Auth\RegisterController@store')->name('register_user');
    // Route::get('/user_create', 'Auth\RegisterController@create')->name('user_create');
    // Route::get('/user_edit/{id}', 'Auth\RegisterController@edit')->name('user_edit');
    // Route::get('/user_show/{id}', 'Auth\RegisterController@show')->name('user_show');
    // Route::put('/user_update/{id}', 'Auth\RegisterController@update')->name('user_update');

    Route::resources(
        [
            'user' => 'Auth\RegisterController',
            'department' => 'User\DepartmentController',
            'status' => 'User\EmployeeStatusController',
            'gender' => 'User\GenderController',
            'role' => 'User\RoleController',
            'function' => 'User\FunctionController',
            'variable' => 'Helpers\VariableController',
            'loan' => 'Money\LoanController',
            // 'advance' => 'Money\AdvanceSalaryController',
        ]
    );

    ///Roles Routes download_wcf
    Route::get('/roles_settings', 'User\RoleController@display_roles')->name('roles_settings');
    Route::get('/populate_roles', 'User\RoleController@populate_roles')->name('populate_roles');
    Route::post('/change_roles', 'User\RoleController@change_roles')->name('change_roles');

    Route::get('/advance', 'Money\AdvanceSalaryController@create')->name('advance.create');
    Route::get('/advance/{user_id}/edit', 'Money\AdvanceSalaryController@edit')->name('advance.edit');
    Route::put('/advance/{user_id}', 'Money\AdvanceSalaryController@update')->name('advance.update');
    Route::post('/advance/store', 'Money\AdvanceSalaryController@store')->name('advance.store');
    Route::get('/advance/home', 'Money\AdvanceSalaryController@index')->name('advance.index');

    Route::get('/download_wcf', 'Auth\RegisterController@index')->name('download_wcf');
    Route::get('/download_pspf', 'Auth\RegisterController@index')->name('download_pspf');
    
    

    Route::get('/download_past/{id}', 'Auth\RegisterController@download_past')->name('past_pspf_wcf_download');
    Route::get('/download_past_payslip', 'Auth\RegisterController@download_past_payslip')->name('download_past_payslip');

    Route::post('/download/payroll', 'Money\PayrollController@download')->name('payroll.download');
    
    ///LOAN 
    Route::post('download_by_date','Money\LoanController@download_by_date')->name('download_by_date');
    Route::get('filter_by_date','Money\LoanController@filter_by_date')->name('filter_by_date');

    Route::get('/system_user',function(){
        return redirect()->route('user.index',['all','system']);
    })->name('system_user');

    Route::get('clear_pending_mail','ClearMailController@index')->name('clear_pending_mail');
});

use App\Models\Auth\UserRoleModel;
use App\Models\Helpers\VariableModel;

View::composer(["*"], function($view){
    $roles = UserRoleModel::roles();

    ////Notifications
    $months = array(
                    1 => "January",
                    2 => "February",
                    3 => "March",
                    4 => "April",
                    5 => "May",
                    6 => "June",
                    7 => "July",
                    8 => "August",
                    9 => "September",
                    10 => "October",
                    11 => "November",
                    12 => "December"
                );

    $months_short = array(
                    1 => "Jan",
                    2 => "Feb",
                    3 => "Mar",
                    4 => "Apr",
                    5 => "May",
                    6 => "Jun",
                    7 => "Jul",
                    8 => "Aug",
                    9 => "Sep",
                    10 => "Oct",
                    11 => "Nov",
                    12 => "Dec"
                );      

    $call_model_sms = function($header,$body,$type){
        ?>
            <script type="text/javascript">
                $(document).ready(function(){
                    call_model("<?=$header;?>", "<?=$body;?>", "<?=$type;?>");

                    function call_model(title, body, type){
                        $("#errorModelButton").click();
                        $("#largeModalLabel").html(title);
                        $("#body_sms").html(body);
                        $("#body_sms").addClass('alert alert-'+type);
                    }
                });
            </script>
        <?php
    };

    $name = Route::currentRouteName();
    $validation = false;
    if(array_key_exists($name,$roles)){
        if(!$roles[$name] == 1){
            $validation = true;
        }
    }else{
        $validation = true;
    }
    if($name == "home"){
        $validation = false;
        $name = "dashboard";
    }
    $view->with([
                'view_months' => $months, 
                'view_months_short' => $months_short, 
                'call_model_sms' => $call_model_sms,
                'navigation' => $roles, 
                'authorization' => $validation, 
                'page_name' => $name, 
                'company_name' => VariableModel::company(), 
                'date_viewer' => function($date){
                                    $date = date_create($date);
                                    return date_format($date ,'d/m/Y');
                                },
                'money_view' => function($money){
                        if(!is_numeric($money)){
                            if($money == "dc"){
                                return "";
                            }
                            $money = "NuN";
                        }else{
                            $money = number_format($money,2);
                        }
                        return $money;
                    },
                'web_nav' => function($key) use($roles){
                        $navigation = $roles;
                        if(array_key_exists($key,$navigation)){
                            if($navigation[$key] == 1){
                                return true;
                            }else{
                                return false;
                            }
                        }else{
                            return false;
                        }
                    },
                'color' => function($color){
                        $bg = "white";
                        if($color == "" || $color == "white"){
                            $bg = "black";
                        }
                        return "background:$color;color:$bg;";
                    }
                ]);
});
