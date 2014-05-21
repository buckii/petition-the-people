<nav class="top-bar" data-topbar role="navigation">
  <ul class="title-area">
    <li class="name">
      {{ link_to_action( 'FrontController@index', trans( 'global.app_name' ), null, [ 'id' => 'site-logo', 'rel' => 'home' ] ) }}
    </li>
  </ul>

  <section class="top-bar-section">
    <ul class="right">
      @if ( Auth::check() )

        <li>{{ link_to_action( 'CampaignController@index', trans( 'campaign.action_index' ) ) }}</li>
        <li>{{ link_to_action( 'UserController@logout', trans( 'user.action_logout' ) ) }}</li>

      @else

        <li>{{ link_to_action( 'UserController@create', trans( 'user.action_register' ) ) }}</li>
        <li>{{ link_to_action( 'UserController@login', trans( 'user.action_login' ) ) }}</li>

      @endif
    </ul>
  </section>
</nav>