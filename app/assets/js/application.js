/**
 * Application scripting
 */
/*global jQuery: true */
/*jslint white: true */
/*jshint browser: true, jquery: true */

/**
 * Toggle classes for the slug check
 *
 * @param obj response Response from the Ajax request
 */
function slugCheckToggle( response ) {
  "use strict";

  var slug = jQuery( '#slug' ),
  msg = jQuery( '#slug-availability' );

  if ( response.available ) {
    if ( ! slug.hasClass( 'available' ) ) {
      slug.removeClass( 'unavailable loading' ).addClass( 'available' );
      msg.html( response.message );
    }

  } else {
    slug.removeClass( 'available loading' ).addClass( 'unavailable' );
    msg.html( response.message );
  }
}

jQuery( function ( $ ) {
  "use strict";

  var slugCheckCache = {};

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
  });

  // Check slug availability
  $('#slug').after( '<p id="slug-availability" />' );
  $('#slug').on( 'keyup', function () {
    var input = $(this),
    val = input.val();

    input.addClass( 'loading' );
    if ( slugCheckCache.hasOwnProperty( val ) ) {
      slugCheckToggle( slugCheckCache[ val ] );

    } else {
      $.get( app.paths.slugCheck, { slug: val }, function ( response ) {
        slugCheckCache[ val ] = response;
        slugCheckToggle( response );
      });
    }
  });

});

$(document).foundation();