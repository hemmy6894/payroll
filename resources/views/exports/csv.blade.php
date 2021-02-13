<table border='1' cellspacing='0'>
    @if(count($data_header))
        <tr>
            <th colspan="{{ count($haeder) }}" align="center" style="font-size:18px;"><center><b>{{ $data_header[0] ?? "Header" }}</b></center></th>
        </tr>
    @endif
    <tr>
        @foreach($haeder as $head)
            <td>{{ $head }}</td>
        @endforeach
    </tr>
    @foreach($array as $arr)
        <tr>
            @foreach($field as $f)
                @if(\is_array($f))
                    @php($f0 = $f[0])
                    <?php unset($f[0]); ?>
                    @php($temp = "")
                    @foreach($f as $s)
                        <td> {{ $arr->$f0->$s }} </td>
                    @endforeach
                @else
                    @php($fs = \explode(",",$f))
                    @php($d = "")
                    @foreach($fs as $f)
                        <td> {{ $arr->$f }} </td>
                    @endforeach
                @endif
             @endforeach
        </tr>
    @endforeach
</table>