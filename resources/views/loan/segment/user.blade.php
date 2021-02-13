<div class="card border-left-success shadow py-2">
    <div class="card-body">
        <div class="row no-gutters align-items-center">
            <div class="col mr-2">
                <h1 class="h4 text-gray-900 mb-4">@lang('words.user_info')</h1>
                <div class="table-responsive">
                    <table class="table table-sm table-striped">
                        <tbody>
                            <tr>
                                <th>
                                    @lang('words.name')
                                </th>
                                <td>
                                    {{ $loan->owned->fname . " " . $loan->owned->lname . " " . $loan->owned->sname }}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    @lang('words.employee_no')
                                </th>
                                <td>
                                    {{ $loan->owned->employee_no }}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    @lang('words.balance')
                                </th>
                                <td class="text-danger">
                                    {{ $money_view($loan->balance) }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>