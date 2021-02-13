<!-- View contain variable $disabled which return '' when not decraled  -->
<div class="col-md-12" style="margin-top:8px">
    <div class="card border-left-success shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <h1 class="h4 text-gray-900 mb-4">@lang('words.money_info')</h1>
                    <table class="table table-sm">
                        <tbody>
                            <tr>
                                <th>
                                    <i class="fas fa-money-check"></i> @lang('words.basic_salary')
                                </th>
                                <td class="text-right">
                                    {{ $money_view($bs = $user->basic_salary) }}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    <i class="fas fa-money-check"></i> @lang('words.paye')
                                </th>
                                <td class="text-right">
                                    {{ $money_view($paye = Calculator::paye($user->basic_salary)) }}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    <i class="fas fa-money-check"></i> @lang('words.pspf_nssf')
                                </th>
                                <td class="text-right">
                                    {{ $money_view($pension = Calculator::pension($user->basic_salary)) }}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    <i class="fas fa-money-check"></i> @lang('words.advance')
                                </th>
                                <td class="text-right">
                                    {{ $money_view($advance = Calculator::advance($user->advance())) }}
                                    <a href="{{ route('advance.index') . '?user='.$user->id }}"><i class="fas fa-eye"></i></a>
                                    <a href="{{ route('advance.create') }}?user={{ $user->id }}"><i class="fas fa-edit"></i></a>
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    <i class="fas fa-money-check"></i> @lang('words.staff_loan')
                                </th>
                                <td class="text-right">
                                    @if($user->active_loan()->count())
                                        {{ $money_view($user->active_loan[0]->amount) }}
                                        <a href="{{ route('loan.show',['loan' => $user->id ]) }}"><i class="fas fa-eye"></i></a>
                                    @else
                                        {{ $money_view(0) }}
                                    @endif
                                    <a href="{{ route('loan.create') }}?user={{ $user->id }}"><i class="fas fa-edit"></i></a>
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    <i class="fas fa-money-check"></i> @lang('words.loan_balance')
                                </th>
                                <td class="text-right text-danger">
                                    @if($user->active_loan()->count())
                                        {{ $money_view($user->active_loan[0]->balance) }}
                                    @else
                                        {{ $money_view(0) }}
                                    @endif
                                </td>
                            </tr>

                            <tr>
                                <th>
                                    <i class="fas fa-money-check"></i> @lang('words.monthly_payment')
                                </th>
                                <td class="text-right">
                                    @if($user->active_loan()->count())
                                        {{ $money_view($monthly_payment = Calculator::month_pay($user->active_loan[0])) }}
                                    @else
                                        {{ $money_view($monthly_payment = 0) }}
                                    @endif
                                </td>
                            </tr>

                            <tr>
                                <th>
                                    <i class="fas fa-money-check"></i> @lang('words.loan_board_amount')
                                </th>
                                <td class="text-right">
                                    @if($user->active_loan_board()->count())
                                        {{ $money_view($user->active_loan_board[0]->amount) }}
                                        <a href="{{ route('loan.show',['loan' => $user->id ]) }}?loan_board"><i class="fas fa-eye"></i></a>
                                    @else
                                        {{ $money_view(0) }}
                                    @endif
                                    <a href="{{ route('loan.create') }}?user={{ $user->id }}&loan_board"><i class="fas fa-edit"></i></a>
                                </td>
                            </tr>
                            
                            <tr>
                                <th>
                                    <i class="fas fa-money-check"></i> @lang('words.loan_balance')
                                </th>
                                <td class="text-right">
                                    @if($user->active_loan_board()->count())
                                        {{ $money_view($user->active_loan_board[0]->balance) }}
                                    @else
                                        {{ $money_view(0) }}
                                    @endif
                                </td>
                            </tr>

                            <tr>
                                <th>
                                    <i class="fas fa-money-check"></i> @lang('words.monthly_payment')
                                </th>
                                <td class="text-right">
                                    @if($user->active_loan_board()->count())
                                        {{ $money_view($monthly_payment1 = Calculator::month_pay($user->active_loan_board[0])) }}
                                    @else
                                        {{ $money_view($monthly_payment1 = 0) }}
                                    @endif
                                </td>
                            </tr>
                            
                            <tr>
                                <th>
                                    <i class="fas fa-money-check"></i> @lang('words.bft_loan_amount')
                                </th>
                                <td class="text-right">
                                    @if($user->active_bft_loan()->count())
                                        {{ $money_view($user->active_bft_loan[0]->amount) }}
                                        <a href="{{ route('loan.show',['loan' => $user->id ]) }}?bft_loan"><i class="fas fa-eye"></i></a>
                                    @else
                                        {{ $money_view(0) }}
                                    @endif
                                    <a href="{{ route('loan.create') }}?user={{ $user->id }}&bft_loan"><i class="fas fa-edit"></i></a>
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    <i class="fas fa-money-check"></i> @lang('words.loan_balance')
                                </th>
                                <td class="text-right">
                                    @if($user->active_bft_loan()->count())
                                        {{ $money_view($user->active_bft_loan[0]->balance) }}
                                    @else
                                        {{ $money_view(0) }}
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    <i class="fas fa-money-check"></i> @lang('words.monthly_payment')
                                </th>
                                <td class="text-right">
                                    @if($user->active_bft_loan()->count())
                                        {{ $money_view($monthly_payment2 = Calculator::month_pay($user->active_bft_loan[0])) }}
                                    @else
                                        {{ $money_view($monthly_payment2 = 0) }}
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    <i class="fas fa-money-check"></i> @lang('words.net_salary')
                                </th>
                                <td class="text-right">
                                    {{ $money_view(Calculator::net_salary([$bs],[$paye,$pension,$monthly_payment,$advance,$monthly_payment1,$monthly_payment2])) }}
                                </td>
                            </tr>

                            <tr>
                                <th>
                                    <i class="fas fa-money-check"></i> @lang('words.payslip')
                                </th>
                                <td class="text-right">
                                 <a href="{{ ($payslip ?? \route('user.index') ).'?payslip='.$user->id }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm pull-right"><i class="fas fa-download fa-sm text-white-50"></i> @lang('words.payslip')</a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>