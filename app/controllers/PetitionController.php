<?php

class PetitionController extends BaseController {

  public function search() {
    $api = new WeThePeopleApi;
    $petitions = $api->search( Input::get( 'term' ) );

    if ( Request::ajax() ) {
      return View::make( 'petition.search-list' )->with( 'petitions', $petitions->results );
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

}
