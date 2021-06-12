@if ($message = Session::get('success'))
    <div class="alert alert-success">
        <button type="button" data-dismiss="alert" aria-hidden="true" class="close">
            <i class="now-ui-icons ui-1_simple-remove"></i>
        </button>
        <span>
        <b> Success - </b> {{ $message }}</span>
    </div>
@elseif($message = Session::get('failed'))
    <div class="alert alert-danger">
        <button type="button" data-dismiss="alert" aria-hidden="true" class="close">
            <i class="now-ui-icons ui-1_simple-remove"></i>
        </button>
        <span>
        <b> Failed - </b> {{ $message }}</span>
    </div>
@endif


@foreach ($errors->all() as $msg)
    <div class="alert alert-danger">
        <button type="button" data-dismiss="alert" aria-hidden="true" class="close">
            <i class="now-ui-icons ui-1_simple-remove"></i>
        </button>
        <span>
        <b> Validation Error - </b> {{ $msg }}</span>
    </div>
@endforeach
