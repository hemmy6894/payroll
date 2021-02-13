@extends('layouts.app2')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-6">
                    @include('loan.segment.edit')
                </div>
                <div class="col-md-6" style="margin-top:6px !important;">
                    @include('loan.segment.user')
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-12 text-right m-1">
                    <a href="{{ $download_link }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm pull-right"><i class="fas fa-download fa-sm text-white-50"></i> @lang('words.generate_report')</a>
                </div>
            </div>
            @include('loan.segment.activities')
        </div>
    </div>
@endsection