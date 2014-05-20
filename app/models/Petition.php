<?php

class Petition extends Eloquent {

  public static $rules = array(
    'wtp_id' => array( 'required_without:id', 'unique:petitions,wtp_id' ),
    'title' => 'required',
    'body' => 'required',
    'signature_threshold' => 'required|integer',
    'signature_count' => 'required|integer',
    'signatures_needed' => 'required|integer',
    'url' => 'required|url',
    'deadline' => 'required|date',
    'status' => 'required',
  );

  protected $protected = array( '*' );

  protected $table = 'petitions';

  public function campaigns() {
    return $this->belongsToMany( 'Campaign' );
  }

  public function getDates() {
    return array( 'created_at', 'updated_at', 'deadline' );
  }

}