@extends( 'layouts.base' )

@section( 'title', trans( "front.$page.page_title" ) )

@section( 'body' )

  <section class="page-header">
    <h1>{{ trans( "front.$page.headline" ) }}</h1>
  </section>

  <div class="primary">
    {{ trans( "front.$page.content", ( isset( $body_vars ) ? $body_vars : [] ) ) }}
  </div>

@stop