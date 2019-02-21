
@if ( Session::has('message') )
    <div class="alert {{ Session::get('class') }} alert-dismissable">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        {!! Session::get('message') !!}
    </div>
@endif
