<table>
    <tr>
        <th><b>S. No.</b></th>
        <th colspan="2"><b>Employee No.</b></th>
        <th colspan="3"><b>Employee Name</b></th>
        <th colspan="2"><b>Employee Basic Salary</b></th>
        <th colspan="2"><b>Employee Gross Salary</b></th>
    </tr>
    @php($i = 1)
    @foreach($wcfs as $wcf)
        <tr>
            <th>{{ $wcf->sn }}</th>
            
            <th colspan="2">
                {{$wcf->employee_no}}
            </th>
            <th colspan="3">{{ $wcf->name }}</th>
            <th colspan="2" align="right">{{ $money_view($wcf->basic_salary) }}</th>
            <th colspan="2" align="right">
                {{$money_view($wcf->basic_salary)}}
            </th>
        </tr>
    @endforeach
    <tr>
        <th></th>
        <th colspan="5"></th>
        <th colspan="2" align="right"><b>{{ $money_view(collect($wcfs)->sum('basic_salary')) }}</b></th>
        <th colspan="2" align="right"><b>{{ $money_view(collect($wcfs)->sum('basic_salary')) }}</b></th>
        <th></th>
    </tr>
    <tr>
        <th></th>
        <th></th>
        <th></th><th></th><th></th>
        <th colspan="3"><b>Worker Contribution Fund</b></th>
        <th colspan="2" align="right"><b>{{ $money_view(collect($wcfs)->sum('basic_salary') * 0.01) }}</b></th>
        <th></th>
    </tr>
</table>