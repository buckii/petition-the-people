<header role="masthead">

  <nav id="primary-nav" role="navigation">
    {{ link_to_action( 'FrontController@index', trans( 'global.app_name' ), null, [ 'id' => 'site-logo' ] ) }}
    <ul>
      @if ( Auth::check() )

        <li>{{ link_to_action( 'UserController@logout', trans( 'user.action_logout' ) ) }}</li>

      @else

        <li>{{ link_to_action( 'UserController@create', trans( 'user.action_register' ) ) }}</li>
        <li>{{ link_to_action( 'UserController@login', trans( 'user.action_login' ) ) }}</li>

      @endif
    </ul>
  </nav>
</header>