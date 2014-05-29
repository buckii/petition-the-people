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

  $('#petition-accordion').on( 'change', 'input', function () {
    var cb = $(this),
    petition = cb.parents( 'dd' ),
    signatureForm = $('#signature-form');

    if ( cb.prop( 'checked' ) ) {
      petition.addClass( 'petition-selected' );
    } else {
      petition.removeClass( 'petition-selected' );
    }

    if ( ! signatureForm.is( ':visible' ) ) {
      signatureForm.slideDown( 200 );
    }
  });

  // In case we come back to the page with errors...
  $('#petition-accordion').find( 'input' ).each( function () {
    var cb = $(this);
    if ( cb.prop( 'checked' ) ) {
      cb.parents( 'dd' ).addClass( 'petition-selected' );
    }
  });

  // Toggle petition lists on campaigns/index
  $('.campaign-list').on( 'click', '.petition-toggle a', function ( e ) {
    var toggle = $(this),
    target = $( toggle.attr( 'href' ) );

    e.preventDefault();

    if ( target.is( ':visible' ) ) {
      target.slideUp(100);
      toggle.removeClass( 'open' );
    } else {
      toggle.addClass( 'open' );
      target.slideDown( 200 );
    }

  });

  // Delete a campaign
  $('#delete-campaign').on( 'click', function ( e ) {
    if ( ! confirm( app.i18n.confirmCampaignDelete ) ) {
      e.preventDefault();
    }
  })

});

$(document).foundation();