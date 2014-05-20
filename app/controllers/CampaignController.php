<?php

class CampaignController extends BaseController {

  public function index() {
    $campaigns = Campaign::currentUser()->get();
    return View::make( 'campaign.index' )->with( 'campaigns', $campaigns );
  }

  public function create() {
    return View::make( 'campaign.create' );
  }

  public function store() {
    $validator = Validator::make( Input::all(), Campaign::$rules );
    if ( $validator->fails() ) {
      return Redirect::back()->withErrors( $validator )->withInput();
    }

    $campaign = new Campaign;
    $campaign->user_id = Auth::user()->id;
    $campaign->name = Input::get( 'name' );
    $campaign->content = Input::get( 'content' );
    $campaign->slug = Input::get( 'slug' );

    $campaign->save();

    if ( $campaign->id ) {

      // Store petition IDs
      $petition_ids = array();
      if ( is_array( Input::get( 'petitions' ) ) ) {
        foreach ( array_unique( Input::get( 'petitions' ) ) as $petition ) {
          $petition_ids[] = PetitionController::createOrUpdate( $petition );
        }
        $campaign->petitions()->sync( $petition_ids );
      }

      return Redirect::action( 'CampaignController@index' )->with( 'success', trans( 'campaign.msg_create_success', [ 'name' => $campaign->name ] ) );

    } else {
      return Redirect::back()->withInput()->withErrors( [ trans( 'campaign.msg_create_error' ) ] );
    }
  }

  public function edit( $id ) {
    $campaign = Campaign::find( $id );

    if ( ! $campaign || ! $campaign->belongsToUser() ) {
      return Redirect::action( 'CampaignController@index' )->withErrors( trans( 'campaign.msg_not_allowed_to_edit_campaign' ) );
    }

    return View::make( 'campaign.edit' )->with( 'campaign', $campaign );
  }

  public function update( $id ) {
    $campaign = Campaign::find( $id );

    if ( ! $campaign || ! $campaign->belongsToUser() ) {
      return Redirect::action( 'CampaignController@index' )->withErrors( trans( 'campaign.msg_not_allowed_to_edit_campaign' ) );
    }

    $input = Input::all();
    $input['id'] = $id;

    $validator = Validator::make( $input, Campaign::$rules );
    if ( $validator->fails() ) {
      return Redirect::back()->withErrors( $validator )->withInput();
    }

    $campaign->name = $input['name'];
    $campaign->content = $input['content'];
    $campaign->is_published = Input::get( 'is_published' );

    if ( $campaign->save() ) {

      // Store petition IDs
      $petition_ids = array();
      if ( is_array( Input::get( 'petitions' ) ) ) {
        foreach ( array_unique( Input::get( 'petitions' ) ) as $petition ) {
          $petition_ids[] = PetitionController::createOrUpdate( $petition );
        }
        $campaign->petitions()->sync( $petition_ids );
      }

      return Redirect::action( 'CampaignController@index' )->with( 'success', trans( 'campaign.msg_edit_success', [ 'name' => $campaign->name ] ) );

    } else {
      return Redirect::back()->withInput()->withErrors( trans( 'campaign.msg_edit_error' ) );
    }
  }

  public function destroy( $id ) {
    $campaign = Campaign::find( $id );
    if ( ! $campaign || ! $campaign->belongsToUser() || $campaign->delete() ) {
      return Redirect::action( 'CampaignController@edit', [ 'id' => $campaign->id ] )->withErrors( 'campaign.msg_not_allowed_to_edit_campaign' );

    } else {
      return Redirect::action( 'CampaignController@index' )->with( 'success', trans( 'campaign.msg_delete_success', array( 'name' => $campaign->name ) ) );
    }
  }

}
