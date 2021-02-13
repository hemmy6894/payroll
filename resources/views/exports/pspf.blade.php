<table>
    <tr>
        <td colspan="2" align="center"><img src="{{ 'nssf_pic.png' }}" alt="" height="100" width="100"></td>
        <th colspan="12" align="center">
            <b>
            THE UNITED REPUBLIC OF TANZANIA <br>
            NATIONAL SOCIAL SECURITY FUND <br> <br>
            INSURED PERSON'S CONTRIBUTION RECORD
            </b>
        </th>
        <td>
            Form: NSSF CON.5
        </td>
    </tr>
    <tr><td colspan="14"></td></tr>
    <tr>
        <th colspan="3" align="right"><b>Employers Name</b></th>
        <td colspan="3">PRIME CONSOLIDATORS LTD</td>
        <td colspan="8"><b>Chq/Mo/Po Number</b></td>
        <td></td>
    </tr>
    <tr>
        <th colspan="3" align="right"><b>Address</b></th>
        <td colspan="3">104784</td>
        <td colspan="8"><b>Date of Chq/Mo/Po</b></td>
        <td>11/27/2019</td>
    </tr>
    <tr>
        <th colspan="3"></th>
        <td colspan="3">DAR ES SALAAM</td>
        <td colspan="8"><b>Amount</b></td>
        <td><b>{{ collect($pspfs)->sum('pension_t') }}</b></td>
    </tr>
    <tr>
        <th colspan="3"></th>
        <td colspan="3">TANZANIA</td>
        <td colspan="8"><b>Bank/Post Office Branch</b></td>
        <td></td>
    </tr>
    <tr>
        <th colspan="3"><b>Employers Registration Number</b></th>
        <td colspan="3">1014131</td>
        <td colspan="8"><b>Cash</b></td>
        <td></td>
    </tr>
    <tr>
        <th colspan="3"><b>Month Contribution</b></th>
        <td colspan="3">{{ date('M') }} - {{ date('d') }}</td>
        <td colspan="8"><b>Receipt No</b></td>
        <td></td>
    </tr>
    <tr>
        <th colspan="3"><b>Region District Code Number</b></th>
        <td colspan="3">1014131</td>
        <td colspan="8"><b>Date of Receipt</b></td>
        <td></td>
    </tr>
    <tr colspan="12"></tr>
    <tr>
        <th><b>S. No.</b></th>
        <th colspan="3"><b>INSURED PERSON'S NAME</b></th>
        <th colspan="1"><b>WAGES</b></th>
        <th colspan="8"><b>MEMBERSHIP No.</b></th>
        <th colspan="1"><b>CONTRIBUTIONS</b></th>
        <th colspan="1"><b>REMARKS</b></th>
    </tr>
    @php($i = 1)
    @foreach($pspfs as $pspf)
        <tr>
            <th>{{ $pspf->sn }}</th>
            <th colspan="3">{{ $pspf->name }}</th>
            <th colspan="1">{{ $pspf->basic_salary }}</th>
            @if($pspf->contribution_no == "")
                @php($contribution = "        ")
            @else
                @php($contribution = $pspf->contribution_no)
            @endif
            @foreach(str_split($contribution) as $str)
                <th>{{ $str }}</th>
            @endforeach
            <th colspan="1">
                {{$pspf->pension_t}}
            </th>
            <th>
                {{$pspf->national_id}}
            </th>
        </tr>
    @endforeach
    <tr>
        <th></th>
        <th colspan="3"></th>
        <th colspan="1"><b>{{ collect($pspfs)->sum('basic_salary') }}</b></th>
        <th></th>
        <th></th>
        <th></th>
        <th></th>
        <th></th>
        <th></th>
        <th></th>
        <th></th>
        <th colspan="1"><b>{{ collect($pspfs)->sum('pension_t') }}</b></th>
        <th></th>
    </tr>
</table>