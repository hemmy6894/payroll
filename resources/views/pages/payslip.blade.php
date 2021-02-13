<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $name ?? "ANASTAZIA WILSON MCHEMBE" }}</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>
<body>
    <table class="table table-striped table-sm" style="width:60% !important" align="center" frame="border">
        <tbody>
            <tr>
                <td colspan="2"></td>
            </tr>
            <tr>
                <th class="2">{{ $name ?? "ANASTAZIA WILSON MCHEMBE" }}</th>
            </tr> 
            <tr>
                <td colspan="2">
                    {{ $department  ?? "IT"}}
                </td>
            </tr>
            <tr>
                <th>
                    @lang('words.employee_no')
                </th>
                <td>
                    {{ $employee_no ?? ""}}
                </td>
            </tr>
            <tr>
                <th>
                    @lang('words.pay_point')
                </th>
                <td>
                    {{ $paypoint ?? "HQ" }}
                </td>
            </tr>
            <tr>
                <th>
                    @lang('words.pension_no')
                </th>
                <td>
                    {{ $pension_no ?? ""}}
                </td>
            </tr>
            <tr>
                <th>
                    @lang('words.account_no')
                </th>
                <td>
                    {{ $account_no ?? "" }}
                </td>
            </tr>
            <tr>
                <th colspan="2" class="text-center"> {{ $m??date('F') }} - {{ $y??date('Y') }} Payment Slip (TZS) </th>
            </tr>
            <tr>
                <th>@lang('words.gross_earnings')</th>
                <th class="text-right">@lang('words.amount')</th>
            </tr>
            <tr>
                <td>
                    @lang('words.basic_salary')
                </td>
                @php($gross_earning_total = 0)
                <td class="text-right">
                    {{ $money_view($basic_salary) }} @php($gross_earning_total += $basic_salary)
                </td>
            </tr>
            <tr>
                <th>@lang('words.total')</th>
                <th class="text-right">{{ $money_view($gross_earning_total)}}</th>
            </tr>
            @php($gross_deduction_total = 0)
            <tr>
                <th>@lang('words.gross_deductions')</th>
                <th class="text-right">@lang('words.amount')</th>
            </tr>
            <tr>
                <td>
                    @lang('words.paye')
                </td>
                <td class="text-right">
                    {{ $money_view(Calculator::paye($basic_salary)) ?? "0.00"}}
                    @php($gross_deduction_total += Calculator::paye($basic_salary))
                </td>
            </tr>
            <tr>
                <td>@lang('words.pspf_nssf')</td>
                <td class="text-right">
                {{ $money_view(Calculator::pension($basic_salary)) ?? "0.00"}}
                    @php($gross_deduction_total += Calculator::pension($basic_salary))
                </td>
            </tr>
            @if(Calculator::advance($advance))
                <tr>
                    <td>@lang('words.advance')</td>
                    <td class="text-right">
                        {{ $money_view(Calculator::advance($advance)) ?? "0.00"}}
                        @php($gross_deduction_total += Calculator::advance($advance))
                    </td>
                </tr>
            @endif
            @if(count($active_loan))
                @if($active_loan[0]->balance)
                    <tr>
                        <td>@lang('words.staff_loan')</td>
                        <td class="text-right">
                            {{ $money_view(Calculator::month_pay(Calculator::loan($id))) ?? "0.00"}}
                            @php($gross_deduction_total += Calculator::month_pay(Calculator::loan($id)))
                        </td>
                    </tr>
                @endif
            @endif
            @if(count($active_loan_board))
                @if($active_loan_board[0]->balance)
                    <tr>
                        <td>@lang('words.loan_board')</td>
                        <td class="text-right">
                            {{ $money_view(Calculator::month_pay(Calculator::loan($id,'board'))) ?? "0.00"}}
                            @php($gross_deduction_total += Calculator::month_pay(Calculator::loan($id,'board')))
                        </td>
                    </tr>
                @endif
            @endif
            @if(count($active_bft_loan))
                @if($active_bft_loan[0]->balance)
                    <tr>
                        <td>@lang('words.bft_loan')</td>
                        <td class="text-right">
                            {{ $money_view(Calculator::month_pay(Calculator::loan($id,'bft_loan'))) ?? "0.00"}}
                            @php($gross_deduction_total += Calculator::month_pay(Calculator::loan($id,'bft_loan')))
                        </td>
                    </tr>
                @endif
            @endif
            <tr>
                <th>@lang('words.total')</th>
                <th class="text-right">{{ $money_view($gross_deduction_total) ?? "200,000"}}</th>
            </tr>
            <tr>
                <th>@lang('words.company_contributions')</th>
                <th class="text-right">@lang('words.amount')</th>
            </tr>
            <tr>
                <td>@lang('words.pspf_nssf_employee')</td>
                <td class="text-right">{{ $money_view($pspf_nssf_employee_total = Calculator::pension($basic_salary))}}</td>
            </tr>
            <tr>
                <th>@lang('words.total')</th>
                <th class="text-right">{{ $money_view($pspf_nssf_employee_total) }}</th>
            </tr>
            <tr>
                <th>@lang('words.tax_analysis')</th>
                <th class="text-right">@lang('words.amount')</th>
            </tr>
            <tr>
                <td>@lang('words.taxample_income')</td>
                <td class="text-right">{{ $money_view($basic_salary) }}</td>
            </tr>
            <tr>
                <td>@lang('words.tax_exemptions')</td>
                <td class="text-right">{{ $money_view(Calculator::pension($basic_salary)) }}</td>
            </tr>
            <tr>
                <th>@lang('words.taxable_amount')</th>
                <th class="text-right">{{ $money_view( $basic_salary - Calculator::pension($basic_salary) ) }}</th>
            </tr>
            <tr>
                <th>@lang('words.net_pay')</th>
                <th class="text-right">{{ $money_view(Calculator::net_salary([$gross_earning_total],[$gross_deduction_total])) }}</th>
            </tr>
        </tbody>
    </table>
</body>
</html>