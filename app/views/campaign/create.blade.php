@extends( 'layouts.base' )

@section( 'title', trans( 'campaign.create_title' ) )

@section( 'body' )

  {{ Form::open( [ 'action' => 'CampaignController@store' ] ) }}

    <h1>{{ trans( 'campaign.create_heading' ) }}</h1>
    @include( 'messages.errors' )

    <ul class="form-list">
      <li>
        {{ Form::label( 'name', trans( 'campaign.field_name' ), [ 'class' => 'required' ] ) }}
        {{ Form::text( 'name' ) }}
      </li>
      <li>
        {{ Form::label( 'content', trans( 'campaign.field_content' ), [ 'class' => 'required' ] ) }}
        {{ Form::textarea( 'content' ) }}
      </li>
      <li>
        {{ Form:: label( 'slug', trans( 'campaign.field_slug' ) ) }}
        {{ Form::text( 'slug' ) }}
        <p class="instructions">{{ trans( 'campaign.slug_field_description' ) }}</p>
      </li>
    </ul>
    <p class="form-submit">
      {{ Form::submit( trans( 'campaign.action_create_submit' ) ) }}
    </p>

  {{ Form::close() }}

@stop