@extends('layouts.app2')
@section('content')
    <div class="row">
        <div class="col-md-6">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <h1 class="h4 text-gray-900 mb-4">@lang('words.past_wcf')</h1>
                        <form method="GET" action="{{ route('download_wcf') }}">
                            @csrf
                            <div class="form-group">
                                <input type="month" name="download_wcf"  max="{{ date('Y') . '-' . date('m') }}" require class="form-control form-control-user" id="download_wcf" placeholder="@lang('words.download_wcf')">
                                @if($errors->has('download_wcf'))
                                    <span class="text-danger"><small>{{ $errors->first('download_wcf') }}</small></span>
                                @endif
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-secondary btn-icon-split pull-right">
                                    <span class="icon text-white-50">
                                    <i class="fas fa-arrow-right"></i>
                                    </span>
                                    <span class="text">@lang('words.btn_past_wcf')</span>
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