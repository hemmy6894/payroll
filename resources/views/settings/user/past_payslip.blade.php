@extends('layouts.app2')
@section('content')
    <div class="row">
        <div class="col-md-6">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <h1 class="h4 text-gray-900 mb-4">@lang('words.past_payslip')</h1>
                        <form method="GET" action="{{ route('user.index') }}">
                            @csrf
                            <div class="form-group">
                                <select name="payslip" require class="form-control form-control-user" id="payslip" placeholder="@lang('words.select_users')">
                                    <option value="{{ NULL }}">@lang('words.select_users')</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->full_name }}</option>
                                    @endforeach
                                </select>
                                @if($errors->has('payslip'))
                                    <span class="text-danger"><small>{{ $errors->first('payslip') }}</small></span>
                                @endif
                            </div>
                            <div class="form-group">
                                <input type="month" name="month" max="{{ date('Y') . '-' . date('m') }}" required class="form-control form-control-user" id="month" placeholder="@lang('words.month')">
                                @if($errors->has('month'))
                                    <span class="text-danger"><small>{{ $errors->first('month') }}</small></span>
                                @endif
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-secondary btn-icon-split pull-right">
                                    <span class="icon text-white-50">
                                    <i class="fas fa-arrow-right"></i>
                                    </span>
                                    <span class="text">@lang('words.btn_download')</span>
                                </button>
                            </div>
                        </form>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection