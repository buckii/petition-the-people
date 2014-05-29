<?php

use Carbon\Carbon;

class PetitionController extends BaseController {

  public function search() {
    $api = new WeThePeopleApi;
    $petitions = $api->search( Input::get( 'term' ) );

    if ( Request::ajax() ) {
      return View::make( 'petition.search-list' )->with( 'petitions', $petitions->results );

    // If it's not Ajax, just return the JSON
    } else {
      return $petitions->results;
    }
  }

  /**
   * Either create or update a petition, depending on whether it already exists
   *
   * @param int $petition_id The petition ID
   */
  public static function createOrUpdate( $petition_id ) {
    $petition = Petition::where( 'wtp_id', '=', $petition_id )->first();
    if ( $petition ) {
      self::maybeRefresh( $petition->id );
      return $petition->id;

    } else {
      $api = new WeThePeopleApi;
      $obj = $api->retrieve( $petition_id );
      $obj = current( $obj->results );

      $petition = new Petition;
      $petition->wtp_id = $obj->id;
      $petition->title = $obj->title;
      $petition->body = $obj->body;
      $petition->signature_threshold = $obj->signatureThreshold;
      $petition->signature_count = $obj->signatureCount;
      $petition->signatures_needed = $obj->signaturesNeeded;
      $petition->url = $obj->url;
      $petition->deadline = $obj->deadline;
      $petition->status = $obj->status;

      $petition->save();
    }

    return $petition->id;
  }

  /**
   * Check the last time a petition was updated and, if it's stale pull a fresh copy from WTP
   *
   * @param int $petition_id The petition object ID
   * @return bool Did we update the petition?
   */
  public static function maybeRefresh( $petition_id ) {
    $petition = Petition::find( $petition_id );
    $now = Carbon::now();

    if( $now->diffInHours( $petition->updated_at ) > 1 ) {
      $api = new WeThePeopleApi;
      $obj = $api->retrieve( $petition->wtp_id, true );
      $obj = current( $obj->results );

      $petition->title = $obj->title;
      $petition->body = $obj->body;
      $petition->signature_threshold = $obj->signatureThreshold;
      $petition->signature_count = $obj->signatureCount;
      $petition->signatures_needed = $obj->signaturesNeeded;
      $petition->url = $obj->url;
      $petition->deadline = $obj->deadline;
      $petition->status = $obj->status;

      $petition->save();
      return true;
    }

    return false;
  }

}
