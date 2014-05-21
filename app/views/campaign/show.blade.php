@extends( 'layouts.base' )

@section( 'title', $campaign->name )

@section( 'body' )

  <h1>{{{ $campaign->name }}}</h1>

  @if ( $campaign->content )

    {{ WTPHelper::autop( $campaign->content ) }}

  @endif

  <dl class="accordion" data-accordion>
    @foreach ( $petitions as $petition )

      <dd>
        <a href="#petition-{{{ $petition->wtp_id }}}">{{{ $petition->title }}}</a>
        <div id="petition-{{{ $petition->wtp_id }}}" class="content">
          {{ WTPHelper::autop( $petition->body ) }}
          <p class="petition-status">{{{ trans( 'petition.current_status', [ 'signatures' => $petition->signature_count, 'needed' => $petition->signatures_needed, 'deadline' => $petition->deadline->format( trans( 'global.date_format' ) ) ] ) }}}</p>
        </div>
      </dd>

    @endforeach
  </dl>

@stop