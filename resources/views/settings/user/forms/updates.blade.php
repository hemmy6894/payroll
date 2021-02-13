<!-- View contain variable $disabled which return '' when not decraled  -->
<div class="col-md-12">
    <div class="card border-left-success shadow py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
            <div class="col mr-2">
                <h1 class="h4 text-gray-900 mb-4">Updates</h1>
                @foreach($user->updates()->orderBy('created_at','DESC')->get() as $update)
                    <div class="row">
                        <div class="col-md-12">
                            {{ $update->body }} <br />
                            <small class="text-success"> {{ @$update->created_user->full_name . " => ".  @$update->created_at}}</small>
                            <hr />
                        </div>
                    </div>
                @endforeach
            </div>
            </div>
        </div>
    </div>
</div>