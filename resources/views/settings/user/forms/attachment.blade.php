<!-- View contain variable $disabled which return '' when not decraled  -->
<div class="col-md-12">
    <div class="card border-left-success shadow py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
            <div class="col mr-2">
                <h1 class="h4 text-gray-900 mb-4">@lang('words.user_attachments')</h1>
                @if(($disabled ?? '') != 'disabled')
                    <form method="POST" action="{{ route('user.update',['user' => $user->id ]) }}?attachment" enctype="multipart/form-data">
                        <fieldset {{ $disabled ?? ''}} >
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <input type="text" value="{{ $user->id }}" name="user_id"  id="examplename" placeholder="@lang('words.enter_name')" hidden>
                                <input type="text" name="name" class="form-control form-control-user" id="examplename" placeholder="@lang('words.enter_name')">
                                @if($errors->has('name'))
                                    <span class="text-danger"><small>{{ $errors->first('name') }}</small></span>
                                @endif
                            </div>
                            <div class="form-group">
                                <input type="file" value="{{ $user->attachment }}" name="attachment" class="form-control form-control-user" id="exampleattachment" placeholder="@lang('words.enter_attachment')">
                                @if($errors->has('attachment'))
                                    <span class="text-danger"><small>{{ $errors->first('attachment') }}</small></span>
                                @endif
                            </div>
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
                @else
                    <table class="table table-striped">
                        @foreach($user->attachments as $attachment)
                            <tr>
                                <td>
                                    {{ $attachment->name }}
                                    <br>
                                    <small class="text-success">
                                        {{ @$attachment->created_user->full_name . ' ' . $attachment->created_at }}
                                    </small>
                                </td>
                                <td><a href ="{{ asset($attachment->attachment) }}" target="_blank">View</a></td>
                            </tr>
                        @endforeach
                    </table>
                @endif
            </div>
            </div>
        </div>
    </div>
</div>