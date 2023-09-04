@if(Session::get('errorMsg'))
    <span class="text-danger">{{ Session::get('errorMsg') }}</span>
@endif
@if(Session::get('successMsg'))
    <span class="text-success">{{ Session::get('successMsg') }}</span>
@endif
