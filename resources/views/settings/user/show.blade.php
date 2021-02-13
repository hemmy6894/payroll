@extends('layouts.app2')
@section('content')
    <div class="row">
        @include('settings.user.forms.personal')
        <div class="col-md-6">
            @include('settings.user.forms.ids')
            <br />
            @include('settings.user.forms.bank')
            <br />
            @include('settings.user.forms.attachment')
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            @include('settings.user.forms.loan_info')
        </div>
        <div class="col-md-6">
            @include('settings.user.forms.updates')
        </div>
    </div>
@endsection