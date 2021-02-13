<div class="card border-left-success shadow py-2">
    <div class="card-body">
        <div class="row no-gutters align-items-center">
            <div class="col mr-2">
                <h1 class="h4 text-gray-900 mb-4">@lang('words.loan_activities')</h1>
                <div class="table-responsive">
                    <table class="table table-sm table-striped">
                        <thead>
                            <tr>
                                <th>@lang('words.loan_no')</th>
                                <th>@lang('words.credit')</th>
                                <th>@lang('words.debit')</th>
                                
                                <th>@lang('words.balance')</th>
                                <th>@lang('words.comment')</th>
                                <th>@lang('words.created_by')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($loans as $loan_a)
                                @foreach($loan_a->activities->sortBy('created_at')->all() as $activity)
                                    <tr>
                                        <td>{{ $loan_a->loan_no }}</td>
                                        <td>{{ $money_view(Calculator::debit_credit($activity->amount)) }}</td>
                                        <td>{{ $money_view(Calculator::debit_credit($activity->amount,'debit')) }}</td>
                                        <td>{{ $money_view($activity->balance) }}</td>
                                        <td>
                                            {!! Calculator::generate_link(Calculator::word_cut($activity->comment,80),"loan::"," ","loan.show","loan") !!}
                                        </td>
                                        <td nowrap>
                                            <small class="text-success">
                                                {{ $activity->user->fname . " " . $activity->user->lname . " " . $activity->user->sname }}
                                                <br />
                                                {{ $activity->created_at }}
                                            </small>
                                        </td>
                                    </tr>
                                @endforeach
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>