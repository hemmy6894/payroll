@extends('layouts.app2')
@section('content')
    <div class="row">
        <div class="col-md-12 text-right m-1">
            <a href="{{ route('loan.create') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm pull-right"><i class="fas fa-asterisk fa-sm text-white-50"></i> @lang('words.btn_new')</a>
            <a href="{{ $download_link }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm pull-right"><i class="fas fa-download fa-sm text-white-50"></i> @lang('words.generate_report')</a>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card border-left-success shadow py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <h1 class="h4 text-gray-900 mb-4">@lang('words.loan')</h1>
                            <div class="table-responsive">
                            @php($type = "")
                            @if(isset($_GET['loan_board']))
                                @php($type = "?loan_board")
                            @endif
                            @if(isset($_GET['bft_loan']))
                                @php($type = "?bft_loan")
                            @endif
                                <table class="table table-bordered dataTable table-sm" id="dataTable" width="100%" cellspacing="0" role="grid" aria-describedby="dataTable_info" style="width: 100%;">
                                    <thead>
                                        <th nowrap>@lang('words.employee')</th>
                                        <th nowrap>@lang('words.total_loan')</th>
                                        <th nowrap>@lang('words.monthly_payment')</th>
                                        <th nowrap>@lang('words.balance')</th>
                                        
                                    </thead>
                                    <tbody>
                                        @forelse($users as $user)
                                            <tr>
                                                <td nowrap>
                                                    @php($loan = Calculator::loan($user->id))
                                                    {!! Calculator::generate_link("loan::$user->id","loan::"," ","loan.show","loan",$user->full_name)  !!}
                                                </td>
                                                <td nowrap>{{ $money_view($loan->amount) }}</td>
                                                <td nowrap>{{ $money_view($loan->monthly_payment) }}</td>
                                                <td nowrap><span class="text-danger">{{ $money_view($loan->balance) }}</span></td>
                                            </tr>
                                        @empty
                                            @lang('words.user_not_found');
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