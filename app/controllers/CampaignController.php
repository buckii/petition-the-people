<?php

class CampaignController extends BaseController {

  public function index() {
    $campaigns = Campaign::currentUser()->get();
    return View::make( 'campaign.index' )->with( 'campaigns', $campaigns );
  }

  public function show( $id ) {
    if ( $campaign = Campaign::find( $id ) ) {
      if ( $campaign->is_published ) {
        return Redirect::action( 'CampaignController@showPublic', [ 'user' => $campaign->user->username, 'slug' => $campaign->slug ] );

      } elseif ( Auth::user()->id === $campaign->user->id ) {
        $vars = array(
          'campaign' => $campaign,
          'petitions' => $campaign->petitions()->open()->get(),
          'message' => trans( 'campaign.msg_show_not_published' )
        );

        return View::make( 'campaign.show' )->with( $vars );
      }
    }

    return App::abort( 404 );
  }

  public function showPublic( $username, $slug ) {
    // This *should* be a join, but it doesn't seem to load petitions when we go that way
    $user_id = User::where( 'username', '=', $username )->pluck( 'id' );
    $campaign = Campaign::where( 'slug', '=', $slug )
      ->where( 'user_id', '=', $user_id )
      ->with( 'petitions' )
      ->firstOrFail();

    if ( $campaign && $campaign->is_published ) {
      $vars = array(
        'campaign' => $campaign,
        'petitions' => $campaign->petitions()->open()->get()
      );
      return View::make( 'campaign.show' )->with( $vars );
    }

    return App::abort( 404 );
  }

  public function create() {
    return View::make( 'campaign.create' );
  }

  public function store() {
    // Fill in the user ID for the slug validation
    $rules = Campaign::$rules;
    foreach ( $rules['slug'] as $k => $rule ) {
      $rules['slug'][ $k ] = str_replace( ':user_id', Auth::user()->id, $rule );
    }

    $validator = Validator::make( Input::all(), $rules );
    if ( $validator->fails() ) {
      return Redirect::back()->withErrors( $validator )->withInput();
    }

    $campaign = new Campaign;
    $campaign->user_id = Auth::user()->id;
    $campaign->name = Input::get( 'name' );
    $campaign->content = Input::get( 'content' );
    $campaign->slug = Input::get( 'slug' );
    $campaign->is_published = Input::get( 'is_published' );

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

    } elseif ( Input::has( 'delete-campaign' ) ) {
      return $this->destroy( $id );
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
    if ( ! $campaign || ! $campaign->belongsToUser() || ! $campaign->delete() ) {
      return Redirect::action( 'CampaignController@edit', [ 'id' => $campaign->id ] )->withErrors( 'campaign.msg_not_allowed_to_edit_campaign' );

    } else {
      return Redirect::action( 'CampaignController@index' )->with( 'success', trans( 'campaign.msg_delete_success', array( 'name' => $campaign->name ) ) );
    }
  }

  public function slugUniquenessCheck() {
    if ( ! Input::has( 'slug' ) ) {
      $response = array(
        'available' => false,
        'message' => trans( 'campaign.msg_slug_not_set' )
      );

    } else {
      $campaign = Campaign::where( 'user_id', '=', Auth::user()->id )
        ->where( 'slug', '=', Input::get( 'slug' ) )
        ->count();

      if ( $campaign ) {
        $response = array(
          'available' => false,
          'message' => trans( 'campaign.msg_slug_taken' )
        );

      } else {
        $response = array(
          'available' => true,
          'message' => trans( 'campaign.msg_slug_available' )
        );
      }
    }

    return $response;
  }

}
