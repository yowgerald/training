@if(Session::has('message'))
    <div class="notification is-success is-light">
        {{ Session::get('message') }}
    </div>
@endif
@if(Session::has('error'))
    <div class="notification is-danger is-light">
        {{ Session::get('error') }}
    </div>
@endif
