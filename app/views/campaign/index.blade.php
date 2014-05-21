@extends( 'layouts.base' )

@section( 'title', trans( 'campaign.index_title' ) )

@section( 'body' )

  <h1>{{ trans( 'campaign.index_heading' ) }}</h1>

  <ul class="actions">
    <li>{{ link_to_action( 'CampaignController@create', trans( 'campaign.action_create' ) ) }}</li>
  </ul>

  @include( 'messages.errors' )

  @if ( count( $campaigns ) )

    <ul class="campaign-list">
      @foreach ( $campaigns as $campaign )

        <li>
          {{ link_to_action( 'CampaignController@edit', $campaign->name, [ 'id' => $campaign->id ] ) }}
          <ul class="row-actions">
            <li>{{ link_to_action( 'CampaignController@show', trans( 'campaign.action_show' ), [ 'id' => $campaign->id ], [ 'class' => 'show', 'title' => trans( 'campaign.action_show_title' ) ] ) }}</li>
            <li>{{ link_to_action( 'CampaignController@edit', trans( 'campaign.action_edit' ), [ 'id' => $campaign->id ], [ 'class' => 'edit', 'title' => trans( 'campaign.action_edit_title' ) ] ) }}</li>
          </ul>
        </li>

      @endforeach
    </ul>

  @else

    <p class="empty-data">{{ trans( 'campaign.index_no_campaigns', [ 'new_campaign' => action( 'CampaignController@create' ) ] ) }}</p>

  @endif

@stop