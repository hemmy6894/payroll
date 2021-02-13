@extends('layouts.app2')
@section('content')
    <div class="col-md-8">
        <div class="card border-left-success shadow py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <h1 class="h4 text-gray-900 mb-4">@lang('words.advance')</h1>
                    @php($type = "?user")
                    @if(isset($_GET['user']))
                        @if(!empty($_GET['user']))
                            @php($type = "?user=".$_GET['user'])
                        @endif
                    @endif
                    
                    <form disabled method="POST" action="{{ route('advance.store') . $type }}">
                        <fieldset {{ $disabled ?? ''}} >
                            @csrf
                            <div class="form-group">
                                <input type="text"  value="{{ $user_name }}" class="form-control form-control-user" id="exampleFirstName" placeholder="@lang('words.amount')" disabled>
                            </div>
                            <div class="form-group">  
                                <input type="text"  name="user_id" value="{{ $user_id }}" id="exampleFirstName" placeholder="@lang('words.amount')" hidden>
                                <input type="text"  name="amount" class="form-control form-control-user" id="exampleFirstName" placeholder="@lang('words.amount')">
                                @if($errors->has('amount'))
                                    <span class="text-danger"><small>{{ $errors->first('amount') }}</small></span>
                                @endif
                            </div>
                            <div class="form-group">
                                <textarea name="comment" class="form-control form-control-user" placeholder="@lang('words.comment')"></textarea>
                                @if($errors->has('comment'))
                                    <span class="text-danger"><small>{{ $errors->first('comment') }}</small></span>
                                @endif
                            </div>
                            <div class="form-group">
                                <input type="radio" checked name="salary_month"  value="{{ 'this' }}" placeholder="@lang('words.salary_month')"> @lang('words.this_month')
                                <input type="radio"  name="salary_month"  value="{{ 'next' }}" placeholder="@lang('words.salary_month')"> @lang('words.next_month')
                                <br />
                                @if($errors->has('salary_month'))
                                    <span class="text-danger"><small>{{ $errors->first('salary_month') }}</small></span>
                                @endif
                            </div>
                            
                            <!--<div class="form-group">-->
                            <!--    <select name="user_id" class="form-control form-control-user" id="exampleUserId" readonly>-->
                            <!--        <option value="{{ NULL }}">@lang('words.user')</option>-->
                            <!--        @foreach($users as $user)-->
                            <!--            <option @if($user_id == $user->id) selected @endif value="{{ $user->id }}">{{ $user->fname . " " .  $user->lname  . " " . $user->sname}}</option>-->
                            <!--        @endforeach-->
                            <!--    </select>-->
                            <!--    @if($errors->has('user_id'))-->
                            <!--        <span class="text-danger"><small>{{ $errors->first('user_id') }}</small></span>-->
                            <!--    @endif-->
                            <!--</div>-->
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