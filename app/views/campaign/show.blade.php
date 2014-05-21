@extends( 'layouts.base' )

@section( 'title', $campaign->name )

@section( 'body' )

  {{ Form::open( [ 'action' => 'SignatureController@store' ] ) }}

    <h1>{{{ $campaign->name }}}</h1>
    @include( 'messages.errors' )

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
            <label>{{ Form::checkbox( 'petition_id[]', $petition->id, false ) }} {{ trans( 'signature.sign_this_petition' ) }}</label>
          </div>
        </dd>

      @endforeach
    </dl>

    <h2>{{ trans( 'campaign.sign_petitions_heading' ) }}
    <fieldset id="signature-form">
      <ul class="form-list">
        <li>
          {{ Form::label( 'first_name', trans( 'signature.field_first_name' ), [ 'class' => 'required' ] ) }}
          {{ Form::text( 'first_name' ) }}
        </li>
        <li>
          {{ Form::label( 'last_name', trans( 'signature.field_last_name' ), [ 'class' => 'required' ] ) }}
          {{ Form::text( 'last_name' ) }}
        </li>
        <li>
          {{ Form::label( 'email', trans( 'signature.field_email' ), [ 'class' => 'required' ] ) }}
          {{ Form::email( 'email' ) }}
        </li>
        <li>
          {{ Form::label( 'postal_code', trans( 'signature.field_postal_code' ), [ 'class' => 'required' ] ) }}
          {{ Form::text( 'postal_code' ) }}
        </li>
      </ul>

      <p class="form-submit">
        {{ Form::submit( trans( 'signature.action_submit' ) ) }}
      </p>
    </fieldset>

    <input name="campaign_id" type="hidden" value="{{{ $campaign->id }}}" />

  {{ Form::close() }}

@stop