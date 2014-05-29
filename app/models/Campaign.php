<?php

class Campaign extends Eloquent {

  public static $rules = array(
    'name' => 'required',
    'content' => 'required',
    'slug' => array(
      'required_without:id',
      'regex:/^[a-z0-9-]+$/',
      'unique:campaigns,slug,null,id,user_id,:user_id'
    )
  );

  protected $fillable = array( 'name', 'content', 'is_published' );

  protected $softDelete = true;

  protected $table = 'campaigns';

  /**
   * Does the campaign belong to a given user_id?
   *
   * @param int $user_id The user ID (will default to the current user)
   * @return bool
   */
  public function belongsToUser( $user_id = null ) {
    if ( ! $user_id ) {
      $user_id = Auth::user()->id;
    }

    return (bool) ( $this->user_id == $user_id );
  }

  public function getUrlAttribute() {
    return action( 'CampaignController@showPublic', [ 'user' => $this->user->username, 'slug' => $this->slug ] );
  }

  public function petitions() {
    return $this->belongsToMany( 'Petition' );
  }

  public function setIsPublishedAttribute( $val ) {
    $this->attributes['is_published'] = (boolean) $val;
  }

  public function user() {
    return $this->belongsTo( 'User' );
  }

  public function scopeCurrentUser( $query ) {
    return $query->where( 'user_id', '=', Auth::user()->id );
  }

  public function signatures() {
    return $this->belongsToMany( 'Signature', 'petition_signature' );
  }

}