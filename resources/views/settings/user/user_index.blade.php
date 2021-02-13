@extends('layouts.app2')
@section('content')
    <div class="row">
        <div class="col-md-12 text-right m-1">
            <a href="{{ route('user.create') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm pull-right"><i class="fas fa-asterisk fa-sm text-white-50"></i> @lang('words.btn_new')</a>
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
                                        <th nowrap>@lang('words.sn')</th>
                                        <th nowrap>@lang('words.employee_no')</th>
                                        <th nowrap>@lang('words.name')</th>
                                        <th nowrap>@lang('words.gender')</th>
                                        <th nowrap>@lang('words.email')</th>
                                        <th nowrap>@lang('words.phone')</th>
                                        <th nowrap>@lang('words.status')</th>
                                        <th nowrap>@lang('words.department')</th>
                                        <th nowrap colspan="2">@lang('words.action')</th>
                                    </thead>
                                    <tbody>
                                        @php($i = 1)
                                        @forelse($users as $user)
                                            @php($net_salary = 0)
                                            <tr>
                                                <td>{{ $i++ }}</td>
                                                <td nowrap>{{ $user->employee_no }}</td>
                                                <td nowrap><a href="{{ route('user.show',['user' => $user->id ]) }}">{{ $user->full_name }}</a></td>
                                                <td nowrap>{{ $user->genders->name }}</td>
                                                <td nowrap>{{ $user->email }}</td>
                                                <td nowrap>{{ $user->phone }}</td>
                                                <td nowrap><span class="btn btn-sm" style="{{ $color(@$user->t_status->bg_color) }}">{{ $user->t_status->name }}</span></td>
                                                <td nowrap>{{ $user->departments->name }}</td>
                                                <td nowrap><a href="{{ $payslip.'='.$user->id }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm pull-right"><i class="fas fa-download fa-sm text-white-50"></i> @lang('words.payslip')</a></td>
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