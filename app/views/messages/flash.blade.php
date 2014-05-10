@if ( Session::has( 'success' ) && Session::get( 'success' ) !== true )
  <div class="flash success">{{ Session::get( 'success' ) }}</div>
@endif

@if ( Session::has( 'message' ) )
  <div class="flash radius">{{ Session::get( 'message' ) }}</div>
@endif