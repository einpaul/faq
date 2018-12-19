@if( session()->has( 'success' ))
    <div class="alert alert-success">
        {{ session()->get( 'success' ) }}
    </div>
@elseif( session()->get( 'warning' ))
    <div class="alert alert-danger">
        {{ session()->get('warning' ) }} <!-- here to 'withWarning()' -->
    </div>
@endif


