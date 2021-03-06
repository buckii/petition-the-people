@extends( 'layouts.base' )

@section( 'document-title' )
  <title>{{ trans( 'global.app_name' ) . ' | ' . strip_tags( trans( 'global.tagline' ) ) }}</title>
  <meta name="description" content="{{{ trans( 'global.site_description' ) }}}" />
@stop

@section( 'body' )

  <div class="main">
    <h1>{{ trans( 'front.index.headline' ) }}</h1>
    {{ trans( 'front.index.content', [ 'create_link' => action( 'UserController@create' ) ] ) }}
  </div>

@stop