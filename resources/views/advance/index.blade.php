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
                            <h1 class="h4 text-gray-900 mb-4">@lang('words.advanced_salary_statement')</h1>
                            <div class="table-responsive">
                            @php($type = "")
                            @if(isset($_GET['loan_board']))
                                @php($type = "?loan_board")
                            @endif
                                <table class="table table-bordered dataTable table-sm" id="dataTable" width="100%" cellspacing="0" role="grid" aria-describedby="dataTable_info" style="width: 100%;">
                                    <thead>
                                        <th nowrap>@lang('words.employee_no')</th>
                                        <th nowrap>@lang('words.name')</th>
                                        <th nowrap>@lang('words.advance')</th>
                                        <th nowrap>@lang('words.created_date')</th>
                                        <th nowrap>@lang('words.paid_date')</th>
                                        <th nowrap>@lang('words.comment')</th>
                                    </thead>
                                    <tbody>
                                        @forelse($advances as $advance)
                                            <tr>
                                                <td nowrap>{{ $advance->users->employee_no }}</td>
                                                <td nowrap>{{ $advance->users->full_name }}</td>
                                                <td nowrap>{{ $money_view($advance->amount) }}</td>
                                                <td nowrap>{{ $advance->created_at }}</td>
                                                <td nowrap>{{ $advance->paid_date }}</td>
                                                <td nowrap>{{ $advance->comment }}</td>
                                            </tr>
                                        @empty
                                            @lang('words.user_not_found');
                                        @endforelse
                                    </tbody>
                                </table>
                                {{ $advances->appends($_GET)->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection