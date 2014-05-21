@extends( 'layouts.base' )

@section( 'title', $campaign->title )

@section( 'body' )

  <h1>{{{ $campaign->name }}}</h1>

  @if ( $campaign->content )

    {{{ $campaign->content }}}

  @endif

  <dl class="accordion" data-accordion>
    @foreach ( $campaign->petitions as $petition )

      <dd>
        <a href="#petition-{{{ $petition->wtp_id }}}">{{{ $petition->title }}}</a>
        <div id="petition-{{{ $petition->wtp_id }}}" class="content">
          {{{ $petition->body }}}
        </div>
      </dd>

    @endforeach
  </dl>

@stop