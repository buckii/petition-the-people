@extends( 'layouts.base' )

@section( 'title', trans( 'campaign.create_title' ) )

@section( 'body' )

  <section class="page-header">
    <h1>{{ trans( 'campaign.create_heading' ) }}</h1>
  </section>

  <div class="main">
    {{ Form::open( [ 'action' => 'CampaignController@store' ] ) }}


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

      <fieldset>
        <legend>{{ Form:: label( 'slug', trans( 'campaign.field_slug' ) ) }}</legend>
        {{ Form:: label( 'slug', trans( 'campaign.field_slug' ), null, [ 'class' => 'screen-reader-text' ] ) }}
        {{ Form::text( 'slug' ) }}
        <p class="instructions">{{ trans( 'campaign.slug_field_description' ) }}</p>
      </fieldset>

      @include( 'petition.search-form' )

      <p class="form-submit">
        {{ Form::submit( trans( 'campaign.action_create_submit' ) ) }}
      </p>

    {{ Form::close() }}
  </div><!-- .main -->

@stop