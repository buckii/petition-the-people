@extends( 'layouts.base' )

@section( 'title', trans( 'campaign.index_title' ) )

@section( 'body' )

  <section class="page-header">
    <h1>{{ trans( 'campaign.index_heading' ) }}</h1>

    <ul class="actions">
      <li>{{ link_to_action( 'CampaignController@create', trans( 'campaign.action_create' ) ) }}</li>
    </ul>
  </section>

  <div class="main">
    @include( 'messages.errors' )

    @if ( count( $campaigns ) )

      <ul class="campaign-list">
        @foreach ( $campaigns as $campaign )

          <li>
            {{ link_to_action( 'CampaignController@edit', $campaign->name, [ 'id' => $campaign->id ] ) }}

            @if ( ! count( $campaign->petitions ) )

              <p class="petition-toggle empty-data">{{ trans( 'campaign.no_petitions' ) }}</p>

            @else

              <p class="petition-toggle"><a href="#petitions-{{ $campaign->id }}" role="button">{{ Lang::choice( 'campaign.n_petitions', count( $campaign->petitions ), [ 'petition_count' => count( $campaign->petitions ) ] ) }}</a></p>
              <ul id="petitions-{{ $campaign->id }}" class="petition-list">
                @foreach ( $campaign->petitions as $petition )

                  <li><a href="{{{ $petition->url }}}" data-tooltip class="has-tip title" title="{{{ WTPHelper::cleanPetitionBody( $petition->body ) }}}" data-petition-id="{{{ $petition->wtp_id }}}">{{ $petition->title }}</a></li>

                @endforeach
              </ul>

            @endif

            <ul class="row-actions">
              <li>{{ link_to_action( 'CampaignController@edit', trans( 'campaign.action_edit' ), [ 'id' => $campaign->id ], [ 'class' => 'edit', 'title' => trans( 'campaign.action_edit_title' ) ] ) }}</li>
              <li>{{ link_to_action( 'CampaignController@show', trans( 'campaign.action_show' ), [ 'id' => $campaign->id ], [ 'class' => 'show', 'title' => trans( 'campaign.action_show_title' ) ] ) }}</li>
            </ul>
          </li>

        @endforeach
      </ul>

    @else

      <p class="empty-data">{{ trans( 'campaign.index_no_campaigns', [ 'new_campaign' => action( 'CampaignController@create' ) ] ) }}</p>

    @endif
  </div>

@stop