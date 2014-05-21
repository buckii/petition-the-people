@extends( 'layouts.base' )

@section( 'title', trans( "front.$page.page_title" ) )

@section( 'body' )

  <h1>{{ trans( "front.$page.headline" ) }}</h1>
  {{ trans( "front.$page.content", ( isset( $body_vars ) ? $body_vars : [] ) ) }}

@stop