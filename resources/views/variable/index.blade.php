@extends('layouts.app2')
@section('content')
    <div class="row">
        <div class="col-md-12 text-right m-1">
            <a href="{{ route('variable.create') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm pull-right"><i class="fas fa-asterisk fa-sm text-white-50"></i> @lang('words.btn_new')</a>
            <a href="{{ $download_link }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm pull-right"><i class="fas fa-download fa-sm text-white-50"></i> @lang('words.generate_report')</a>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card border-left-success shadow py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <h1 class="h4 text-gray-900 mb-4">@lang('words.variable')</h1>
                            <div class="table-responsive">
                                <table class="table table-bordered dataTable" id="dataTable" width="100%" cellspacing="0" role="grid" aria-describedby="dataTable_info" style="width: 100%;">
                                    <thead>
                                        <th>@lang('words.name')</th>
                                        <th>@lang('words.body')</th>
                                        <th colspan="3">@lang('words.action')</th>
                                    </thead>
                                    <tbody>
                                        @forelse($variables as $variable)
                                            <tr>
                                                <td>{{ $variable->name }}</td>
                                                <td>{{ $variable->body }}</td>
                                                <td><a href="{{ route('variable.show',['variable' => $variable->id ]) }}" class="btn btn-sm btn-success"><span class="fas fa-eye"></span></a></td>
                                                <td><a href="{{ route('variable.edit',['variable' => $variable->id ]) }}" class="btn btn-sm btn-warning"><span class="fas fa-pen"></span></a></td>
                                                <td>
                                                    <a href="{{ route('variable.edit',['variable' => $variable->id ]) }}?block={{$variable->status}}" class="btn btn-sm btn-danger">
                                                        @if($variable->status)
                                                            Block
                                                        @else
                                                            Unblock
                                                        @endif
                                                    </a>
                                                </td>
                                            </tr>
                                        @empty
                                            @lang('words.user_not_found');
                                        @endforelse
                                    </tbody>
                                </table>
                                {{ $variables->appends($_GET)->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection