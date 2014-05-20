/**
 * Application scripting
 */
/*global jQuery: true */
/*jslint white: true */
/*jshint browser: true, jquery: true */

jQuery( function ( $ ) {
  "use strict";

  $('#petition-search').on( 'keyup', '#search', function () {
    var input = $(this),
    data = {
      term: input.val()
    };

    input.addClass( 'loading' );
    $.get( app.paths.search, data, function ( response ) {
      $('#petition-search-results').html( response );
      input.removeClass( 'loading' );
    });

  }).on( 'click', '#petition-search-results a', function ( e ) {
    var petition = $(this),
    li = $('<li />');
    e.preventDefault();

    li.html( petition.clone() );
    li.append( '<input name="petitions[]" type="hidden" value="' + petition.data( 'petition-id' ) + '" />' );
    $('#petition-ids').append( li );
  });

});