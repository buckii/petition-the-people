<?php

class SignatureController extends BaseController {

  public function store() {
    $validator = Validator::make( Input::all(), Signature::$rules );
    if ( $validator->fails() ) {
      return Redirect::to( URL::previous() . '#signature-form' )->withErrors( $validator )->withInput();
    }

    $signature = new Signature;
    $signature->first_name = Input::get( 'first_name' );
    $signature->last_name = Input::get( 'last_name' );
    $signature->email = Input::get( 'email' );
    $signature->postal_code = Input::get( 'postal_code' );
    $signature->user_agent = Request::server( 'HTTP_USER_AGENT' );
    $signature->ip_address = Request::server( 'REMOTE_ADDR' );

    $signature->save();

    if ( $signature->id ) {

      // Relate the signature to the petition and campaign
      if ( Input::has( 'petition_id' ) ) {
        $petition_ids = array_fill_keys( Input::get( 'petition_id' ), array( 'campaign_id' => Input::get( 'campaign_id' ) ) );
        $signature->petitions()->sync( $petition_ids );
      }

      // Submit signatures to We The People
      $api = new WeThePeopleApi;
      try {
        $signature->petitions->each( function ( $petition ) use ( $api, $signature ) {
          $api->signature( $petition->wtp_id, $signature );
        });
      } catch ( GuzzleHttp\Exception\ServerException $e ) {
        $signature->status = $e->getResponse()->getStatusCode();
        if ( $e->hasResponse() ) {
          $signature->status_description = $e->getResponse()->getReasonPhrase();
        }
        $signature->save();

        return Redirect::back()->with( 'message', trans( 'signature.msg_will_submit_later' ) );
      }

      return Redirect::back()->with( 'success', Lang::choice( 'signature.msg_create_success', count( $petition_ids ), [ 'petition_count' => count( $petition_ids ) ] ) );

    } else {
      return Redirect::back()->withInput()->withErrors( [ trans( 'signature.msg_create_error' ) ] );
    }
  }

}
