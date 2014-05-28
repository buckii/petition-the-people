@extends( 'layouts.base' )

@section( 'title', trans( 'campaign.edit_title' ) )

@section( 'body' )

  <section class="page-header">
    <h1>{{ trans( 'campaign.edit_heading' ) }}</h1>
  </section>

  {{ Form::model( $campaign, [ 'action' => [ 'CampaignController@update', $campaign->id ], 'method' => 'put' ] ) }}

    <div class="primary">
      @include( 'messages.errors' )

      <ul class="form-list">
        <li>
          {{ Form::label( 'name', trans( 'campaign.field_name' ), [ 'class' => 'required' ] ) }}
          {{ Form::text( 'name' ) }}
        </li>
        <li>
          {{ Form::label( 'campaign-content', trans( 'campaign.field_content' ), [ 'class' => 'required' ] ) }}
          {{ Form::textarea( 'content', null, [ 'id' => 'campaign-content' ] ) }}
        </li>
      </ul>
    </div>

    <div class="secondary">
      <ul class="form-list panel">
        <li>
          <label for="is_published">{{ Form::checkbox( 'is_published', true, null, [ 'id' => 'is_published' ] ) }} {{ trans( 'campaign.field_is_published' ) }}</label>
        </li>
      </ul>
    </div>

    <div class="primary">
      @include( 'petition.search-form' )

      <p class="form-submit">
        {{ Form::submit( trans( 'campaign.action_edit_submit' ) ) }}
      </p>
    </div>

    {{ Form::close() }}

@stop