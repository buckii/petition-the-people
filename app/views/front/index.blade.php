@extends( 'layouts.base' )

@section( 'document-title' )
  <title>{{ trans( 'global.app_name' ) . ' | ' . strip_tags( trans( 'global.tagline' ) ) }}</title>
  <meta name="description" content="{{{ trans( 'global.site_description' ) }}}" />
@stop

@section( 'body' )

  <h1>foo</h1>

@stop