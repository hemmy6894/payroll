@extends('layouts.app2')
@section('content')
    <div class="row">
        <div class="col-md-12 text-right m-1">
            <a href="{{ route('user.create') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm pull-right"><i class="fas fa-asterisk fa-sm text-white-50"></i> @lang('words.btn_new')</a>
            <a href="{{ $download_link }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm pull-right"><i class="fas fa-download fa-sm text-white-50"></i> @lang('words.generate_report')</a>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card border-left-success shadow py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <h1 class="h4 text-gray-900 mb-4">@lang('words.users')</h1>
                            <div class="table-responsive">
                                <table class="table table-sm table-bordered dataTable" id="dataTable" width="100%" cellspacing="0" role="grid" aria-describedby="dataTable_info" style="width: 100%;">
                                    <thead>
                                        <th nowrap>@lang('words.name')</th>
                                        <th nowrap>@lang('words.basic_salary')</th>
                                        <th nowrap>@lang('words.pspf_nssf')</th>
                                        <th nowrap>@lang('words.paye')</th>
                                        <th nowrap>@lang('words.advance')</th>
                                        <th nowrap>@lang('words.loan')</th>
                                        <th nowrap>@lang('words.loan_board')</th>
                                        <th nowrap>@lang('words.bft_loan')</th>
                                        <th nowrap>@lang('words.net_salary')</th>
                                        <!-- <th nowrap>@lang('words.sdl')</th> -->
                                        <th nowrap>@lang('words.employee_status')</th>
                                        <th nowrap colspan="6">@lang('words.action')</th>
                                    </thead>
                                    <tbody>
                                        
                                        @forelse($users as $user)
                                            @php($net_salary = 0)
                                            <tr>
                                                <td nowrap><a href="{{ route('user.show',['user' => $user->id ]) }}">{{ $user->fname . " " . $user->lname . " " . $user->sname }}</a></td>
                                                <td nowrap>{{ $money_view($bs = $user->basic_salary) }}</td>
                                                <td nowrap>{{ $money_view($pension = Calculator::pension($user->basic_salary)) }}</td>
                                                <td nowrap>{{ $money_view($paye = Calculator::paye($user->basic_salary)) }}</td>
                                                <td nowrap>{{ $money_view($advance = Calculator::advance($user->advance())) }}</td>
                                                <td nowrap>{{ $money_view($monthly_payment = Calculator::month_pay(Calculator::loan($user->id))) }}<br /> <span class="text-danger">(Loan Bal. Tsh {{ $money_view(Calculator::loan($user->id)->balance) }})</span></td>
                                                <td nowrap>{{ $money_view($monthly_payment2 =  Calculator::month_pay(Calculator::loan($user->id,'board'))) }} @php($net_salary -= Calculator::loan($user->id,'board')->monthly_payment)</td>
                                                <td nowrap>{{ $money_view($monthly_payment3 =  Calculator::month_pay(Calculator::loan($user->id,'bft_loan'))) }} @php($net_salary -= Calculator::loan($user->id,'bft_loan')->monthly_payment)</td>
                                                <td nowrap>{{ $money_view(Calculator::net_salary([$bs],[$paye,$pension,$monthly_payment,$monthly_payment2,$advance,$monthly_payment3]))}}</td>
                                                <!-- <td nowrap>{{ $money_view(Calculator::sdl($user->basic_salary)) }}</td> -->
                                                <td nowrap><span class="btn btn-sm" style="{{ $color(@$user->t_status->bg_color) }}">{{ $user->t_status->name }}</span></td>
                                                <td nowrap><a href="{{ $payslip.'='.$user->id }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm pull-right"><i class="fas fa-download fa-sm text-white-50"></i> @lang('words.payslip')</a></td>
                                            </tr>
                                        @empty
                                            @lang('words.user_not_found')
                                        @endforelse
                                    </tbody>
                                </table>
                                {{ $users->appends($_GET)->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection