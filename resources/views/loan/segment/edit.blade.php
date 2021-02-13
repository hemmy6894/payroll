<div class="card border-left-success shadow py-2">
    <div class="card-body">
        <div class="row no-gutters align-items-center">
        <div class="col mr-2">
            <h1 class="h4 text-gray-900 mb-4">@lang('words.loan_details')</h1>
            @php($type = "")
            @if(isset($_GET['loan_board']))
                @php($type = "?loan_board")
            @endif
             @if(isset($_GET['bft_loan']))
                @php($type = "?bft_loan")
            @endif
            <form disabled method="POST" action="{{ route('loan.update',['loan' => $loan->id ])  . $type}}">
                <fieldset {{ $disabled ?? ''}} >
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        
                        <input type="text"  name="user_id" value="{{ $loan->user_id }}" id="exampleFirstName" placeholder="@lang('words.enter_name')" hidden>
                        <div class="row">
                            <div class="col-md-3 text-left"><b>@lang('words.total_loan')</b></div>
                            <div class="col-md-9">
                                <input type="text"  name="amount" value="{{ $loan->amount }}" class="form-control form-control-user" id="exampleFirstName" placeholder="@lang('words.amount')">
                                @if($errors->has('amount'))
                                    <span class="text-danger"><small>{{ $errors->first('amount') }}</small></span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-3 text-left"><b>@lang('words.monthly_payment')</b></div>
                            <div class="col-md-9">
                                <input type="text"  name="monthly_pay" value="{{ $loan->monthly_payment }}"  class="form-control form-control-user" id="exampleFirstName" placeholder="@lang('words.monthly_pay')">
                                @if($errors->has('monthly_pay'))
                                    <span class="text-danger"><small>{{ $errors->first('monthly_pay') }}</small></span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <!--<div class="form-group">-->
                    <!--    <input type="date"  name="start_at"  value="{{ $loan->start_at }}"class="form-control form-control-user" id="exampleFirstName" placeholder="@lang('words.start_at')">-->
                    <!--    @if($errors->has('start_at'))-->
                    <!--        <span class="text-danger"><small>{{ $errors->first('start_at') }}</small></span>-->
                    <!--    @endif-->
                    <!--</div>-->
                    @if(($disabled ?? '') != 'disabled')
                        <div class="form-group">
                            <button type="submit" class="btn btn-secondary btn-icon-split pull-right">
                                <span class="icon text-white-50">
                                <i class="fas fa-arrow-right"></i>
                                </span>
                                <span class="text">@lang('words.btn_submit')</span>
                            </button>
                        </div>
                    @endif
                </fieldset>
            </form>
        </div>
        </div>
    </div>
</div>