@extends( 'layouts.base' )

@section( 'title', $campaign->name )

@section( 'body' )

  {{ Form::open( [ 'action' => 'SignatureController@store' ] ) }}

    <h1>{{{ $campaign->name }}}</h1>

    @if ( $campaign->content )

      {{ WTPHelper::autop( $campaign->content ) }}

    @endif

    <h2>{{ trans( 'campaign.petitions_heading' ) }}</h2>
    <dl id="petition-accordion" class="accordion" data-accordion>
      @foreach ( $petitions as $petition )

        <dd>
          <a href="#petition-{{{ $petition->wtp_id }}}">{{{ $petition->title }}}</a>
          <div id="petition-{{{ $petition->wtp_id }}}" class="content">
            {{ WTPHelper::autop( $petition->body ) }}
            <p class="petition-status">{{{ trans( 'petition.current_status', [ 'signatures' => $petition->signature_count, 'needed' => $petition->signatures_needed, 'deadline' => $petition->deadline->format( trans( 'global.date_format' ) ) ] ) }}}</p>
            <label class="has-switch">{{ Form::checkbox( 'petition_id[]', $petition->id, false, [ 'id' => 'petition-id-' . $petition->id, 'class' => 'switch' ] ) }} {{ trans( 'signature.sign_this_petition' ) }}</label>
          </div>
        </dd>

      @endforeach
    </dl>

    <fieldset id="signature-form" {{ ( $errors->all() ? ' class="has-errors"' : '' ) }}>
      <h2>{{ trans( 'campaign.sign_petitions_heading' ) }}</h2>
      @include( 'messages.errors' )

      <ul class="form-list">
        <li>
          {{ Form::label( 'first_name', trans( 'signature.field_first_name' ), [ 'class' => 'required', 'required' ] ) }}
          {{ Form::text( 'first_name' ) }}
        </li>
        <li>
          {{ Form::label( 'last_name', trans( 'signature.field_last_name' ), [ 'class' => 'required', 'required' ] ) }}
          {{ Form::text( 'last_name' ) }}
        </li>
        <li>
          {{ Form::label( 'email', trans( 'signature.field_email' ), [ 'class' => 'required', 'required' ] ) }}
          {{ Form::email( 'email' ) }}
        </li>
        <li>
          {{ Form::label( 'postal_code', trans( 'signature.field_postal_code' ), [ 'class' => 'required', 'required', 'pattern' => '[0-9]*' ] ) }}
          {{ Form::text( 'postal_code' ) }}
        </li>
      </ul>

      <p class="instructions">{{ trans( 'signature.process_instructions' ) }}</p>
      <p class="instructions">{{ trans( 'signature.terms' ) }}</p>

      <p class="form-submit">
        {{ Form::submit( trans( 'signature.action_submit' ) ) }}
      </p>
    </fieldset>

    <input name="campaign_id" type="hidden" value="{{{ $campaign->id }}}" />

  {{ Form::close() }}

@stop