<?php

class Signature extends Eloquent {

  public static $rules = array(
    'first_name' => 'required',
    'last_name' => 'required',
    'email' => 'required|email',
    'postal_code' => 'required',
    'ip_address' => 'ip',
  );

  protected $protected = array( 'id' );

  protected $table = 'signatures';

  public function petitions() {
    return $this->belongsToMany( 'Petition', 'petition_signature' );
  }

  public function signatures() {
    return $this->belongsToMany( 'Signature', 'petition_signature' );
  }

}