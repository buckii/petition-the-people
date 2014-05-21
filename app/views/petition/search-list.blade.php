@if( count( $petitions ) )

  <ul>
    @foreach( $petitions as $petition )

      <li>
        <a href="{{{ $petition->url }}}" class="title" title="{{{ WTPHelper::cleanPetitionBody( $petition->body ) }}}" data-petition-id="{{{ $petition->id }}}">{{ $petition->title }}</a>
      </li>

    @endforeach
  </ul>

@else

  <p class="empty-data">{{ trans( 'petition.no_search_results' ) }}</p>

@endif