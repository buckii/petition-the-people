@extends( 'layouts.base' )

@section( 'title', trans( 'campaign.index_title' ) )

@section( 'body' )

  <h1>{{ trans( 'campaign.index_heading' ) }}</h1>

  <ul class="actions">
    <li>{{ link_to_action( 'CampaignController@create', trans( 'campaign.action_create' ) ) }}</li>
  </ul>

  @include( 'messages.errors' )

  @if ( count( $campaigns ) )

    <ul class="entity-list">
      @foreach ( $campaigns as $campaign )

        <li>
          {{ link_to_action( 'CampaignController@edit', $campaign->name, [ 'id' => $campaign->id ] ) }}
        </li>

      @endforeach
    </ul>

  @else

    <p class="empty-data">{{ trans( 'campaign.index_no_campaigns' ) }}</p>

  @endif

@stop