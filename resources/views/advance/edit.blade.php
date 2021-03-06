@extends('layouts.app2')
@section('content')
    <div class="col-md-7">
        <div class="card border-left-success shadow py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <h1 class="h4 text-gray-900 mb-4">@lang('words.advance')</h1>
                    @php($type = "")
                    @if(isset($_GET['advance_board']))
                        @php($type = "?advance_board")
                    @endif
                    <form disabled method="POST" action="{{ route('advance.store') . $type }}">
                        <fieldset {{ $disabled ?? ''}} >
                            @csrf
                            <div class="form-group">
                                <input type="text" value="{{ $advance->amount }}" name="amount" class="form-control form-control-user" id="exampleFirstName" placeholder="@lang('words.amount')">
                                @if($errors->has('amount'))
                                    <span class="text-danger"><small>{{ $errors->first('amount') }}</small></span>
                                @endif
                            </div>
                            <div class="form-group">
                                <input type="text" value="{{ $advance->salary_month }}" name="salary_month" class="form-control form-control-user" id="exampleFirstName" placeholder="@lang('words.salary_month')">
                                @if($errors->has('salary_month'))
                                    <span class="text-danger"><small>{{ $errors->first('salary_month') }}</small></span>
                                @endif
                            </div>
                            <div class="form-group">
                                <select name="user_id" class="form-control form-control-user" id="exampleUserId">
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->fname . " " .  $user->lname  . " " . $user->sname}}</option>
                                    @endforeach
                                </select>
                                @if($errors->has('user_id'))
                                    <span class="text-danger"><small>{{ $errors->first('user_id') }}</small></span>
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