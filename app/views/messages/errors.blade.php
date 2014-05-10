@if ( $errors->all() )

  <ul class="flash error">
    @foreach ( $errors->all() as $error )
      <li>{{ $error }}</li>
    @endforeach
  </ul>

@endif