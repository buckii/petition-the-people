<h2>{{ trans( 'petition.heading_current_petitions' ) }}</h2>
<ul id="petition-ids">
  @if ( isset( $campaign ) )
    @foreach ( $campaign->petitions as $petition )

      <li>
        <a href="{{{ $petition->url }}}" class="title" data-petition-id="{{{ $petition->wtp_id }}}">{{ $petition->title }}</a>
        <input name="petitions[]" type="hidden" value="{{{ $petition->wtp_id }}}" />
      </li>

    @endforeach
  @endif
</ul>

<fieldset id="petition-search">
  {{ Form::label( 'search', trans( 'petition.field_search' ) ) }}
  {{ Form::text( 'search', null, [ 'type' => 'search', 'placeholder' => trans( 'petition.field_search_input_placeholder' ) ] ) }}

  <div id="petition-search-results"></div>
</fieldset>