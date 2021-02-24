@extends('layouts.app2')

@section('content')
<div class="container">
    <div class="animated fadeIn" align="center">
        @web_nav('dashboard')
            <?php
                function widget($d=[]){
                $count_num = $d['count']??0;
                $icon = $d['icon']??'file';
                if($count_num < 1 && $icon == "exclamation-triangle"){
                    $icon = "thumbs-o-up";
                }
            ?>
                <div class="col-lg-4 col-md-6 text-left">
                    <a href="{{$d['link']??'#'}}">
                        <div class="card border-left-{{ $count_num > 0 ? 'danger' : 'success' }} shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold {{ $count_num > 0 ? 'text-danger' : 'text-success' }} text-uppercase mb-1">
                                        {!!$d['table']??'Error'!!}</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{$count_num}}</div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-fw fa-{{$icon}} fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            <?php
                }
            ?>

            <div class="row">
                @foreach($dashboards as $dashboard)
                    {{ widget($dashboard) }}
                @endforeach
            </div>
            
        @else
            <img src="{{ asset('global.jpg') }}" />        
        @endif
    </div>
</div>
@endsection

@section('datatable_section')
<script src="//cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.3/jspdf.min.js"></script>
<script>
    let ctx_two = {};
</script>
    <div class="row">
            <?php
                function js_str($s)
                {
                    return "'" . addcslashes($s, "\0..\37\"\\") . "'";
                }
                
                function js_array($array)
                {
                    $temp = array_map('js_str', $array);
                    return '[' . implode(',', $temp) . ']';
                }
                
                function chart_javascript_dataset($data,$start="[",$end="]"){
                    $back = $start;
                    $count_data_f = 0;
                    foreach($data as $keyd => $d){
                        $count_data_f++;
                        $count_data = 0;
                        if(is_array($d)){
                            $key_back_of = "";
                            if(is_numeric($keyd)){
                               $key_back_of = ""; 
                            }else if($keyd != ""){
                               $key_back_of = "\"$keyd\" : ";
                            }
                            $back .= "$key_back_of{";
                                foreach($d as $key => $value){
                                    $count_data++;
                                    $value_ = is_array($value) ? js_array($value) : "\"$value\"";
                                    $back .= "\"$key\": $value_" . ((count($d)==$count_data)? "" :',');
                                }
                            $back .= "}" . ((count($data)==$count_data_f)?"":',');
                        }else{
                            $back .= "\"$keyd\": $d" . ((count($data)==$count_data_f)? "" :',');
                        }
                       
                    }
                    $back .= $end;
                    return $back;
                }
            
                if($web_nav('dashboard')){
                    function widget2($charts=[]){
                        foreach($charts as $key => $value){
                            $date_download = date('Y-m-d-H:i:s');
                            ?>
                                <div class="{{ $value['class']??'col-md-6' }}">
                                    <div class="card">
                                        <div class="card-body">
                                            <h4 class="mb-3 text-center"> {{ $value['name']??'Header' }} <button id="{{$key}}_download" class="btn btn-success pull-right" ><i class="fa fa-pdf"></i> PDF </button> </h4>
                                            <canvas id="{{ $key }}"></canvas>
                                        </div>
                                    </div>
                                </div>
                                
                                <script>
                                    ctx_two["{{$key}}"] = document.getElementById( "{{ $key }}" );
                                    //    ctx_two.height = 200;
                                    var myChart = new Chart( ctx_two["{{$key}}"], {
                                        type: "{{ $value['type']}}",
                                        data: {
                                            labels: <?php echo js_array($value['data']['labels']); ?>,
                                            datasets: <?php echo chart_javascript_dataset($value['data']['datasets']); ?>
                                        },
                                        options: <?php echo chart_javascript_dataset($value['data']['options'],"{","}"); ?>
                                    } );
                                    
                                    document.getElementById( "{{ $key }}_download" ).addEventListener("click", function() {
                                      // only jpeg is supported by jsPDF
                                      var imgData = ctx_two["{{$key}}"].toDataURL();
                                      var pdf = new jsPDF('l');
                                    
                                      pdf.addImage(imgData, 'JPEG', 0, 0, 0, 0);
                                      pdf.save("{{$date_download}}_{{$key}}.pdf");
                                    }, false);
                                </script>
                            <?php
                        }
                    }
                    // widget2($charts);
                }
            ?>
        </div>
@endsection

@section('model_errors')
        <?php
            if(0 == 1){
                $call_model_sms("Do Locked","Do locked by $locker","success");
            }
        ?>
@endsection

