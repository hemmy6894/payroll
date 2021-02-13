@extends('layouts.app2')
@section('content')
    <div class="col-md-8">
        <div class="card border-left-success shadow py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <h1 class="h4 text-gray-900 mb-4">@lang('words.loan')</h1>
                    @php($type = "")
                    @if(isset($_GET['loan_board']))
                        @php($type = "?loan_board")
                    @endif
                    @if(isset($_GET['bft_loan']))
                        @php($type = "?bft_loan")
                    @endif
                    <form disabled method="POST" action="{{ route('loan.store') . $type }}">
                        <fieldset {{ $disabled ?? ''}} >
                            @csrf
                            <div class="form-group">
                                 <input type="text" value="{{ $user->full_name }}" class="form-control form-control-user" id="exampleFirstName" placeholder="@lang('words.enter_name')" readonly><br />
                                <input type="text"  name="user_id" value="{{ $user_id }}" id="exampleFirstName" placeholder="@lang('words.enter_name')" hidden>
                                <input type="text"  name="amount" class="form-control form-control-user" id="exampleFirstName" placeholder="@lang('words.amount')">
                                @if($errors->has('amount'))
                                    <span class="text-danger"><small>{{ $errors->first('amount') }}</small></span>
                                @endif
                            </div>
                            <div class="form-group">
                                <input type="text"  name="monthly_pay" class="form-control form-control-user" id="exampleFirstName" placeholder="@lang('words.monthly_pay')">
                                @if($errors->has('monthly_pay'))
                                    <span class="text-danger"><small>{{ $errors->first('monthly_pay') }}</small></span>
                                @endif
                            </div>
                            
                            <div class="form-group">
                                <textarea type="text"  name="comment" class="form-control form-control-user" id="exampleFirstName" placeholder="@lang('words.comment')"></textarea>
                                @if($errors->has('comment'))
                                    <span class="text-danger"><small>{{ $errors->first('comment') }}</small></span>
                                @endif
                            </div>
                            
                            <div class="form-group">
                                <!--<input type="radio" checked name="start_at"  value="{{ 'this' }}" placeholder="@lang('words.start_at')"> @lang('words.this_month')-->
                                <input type="radio"  name="start_at"  value="{{ 'next' }}" placeholder="@lang('words.start_at')"> @lang('words.next_month')
                                <input type="radio" checked name="start_at"  value="{{ 'this' }}" placeholder="@lang('words.start_at')"> @lang('words.this_month')
                                <br />
                                @if($errors->has('start_at'))
                                    <span class="text-danger"><small>{{ $errors->first('start_at') }}</small></span>
                                @endif
                            </div>
                            @if(($disabled ?? '') != 'disabled')
                                <div class="form-group">
                                    <button type="submit" class="btn btn-secondary btn-icon-split pull-right">
                                        <span class="icon text-white-50">
                                        <i class="fas fa-arrow-right"></i>
                                        </span>
                                        <span class="text">@lang('words.btn_submit')</span>
                                    </button>
                                </div>
                            @endif
                        </fieldset>
                    </form>
                </div>
                </div>
            </div>
        </div>
    </div>
@endsection