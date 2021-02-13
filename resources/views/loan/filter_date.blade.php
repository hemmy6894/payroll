@extends('layouts.app2')
@section('content')
    <div class="row">
        <div class="col-md-12 colo-12">
            <div class="row">
                <div class="col-md-6 col-12">
                    <div class="card border-left-success shadow py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <form class="form" method="POST" action="{{ route('download_by_date')}}">
                                        @csrf
                                        <div class="form-group row"  >
                                            <div class="col-md-8 col-12">
                                                <label for"date">Select Month</label>
                                                <input type="month" class="form-control" value="{{ date('Y-m') }}" name="date">
                                            </div>
                                            <div class="col-md-8 col-12 mt-1">
                                                <input type="submit" class="btn btn-success" value="Filter">
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection