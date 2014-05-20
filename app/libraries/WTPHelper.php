<?php

class WTPHelper {

  public static function getScriptLocalizationObject() {
    $obj = array(
      'paths' => array(
        'search' => action( 'PetitionController@search' )
      )
    );
    return json_encode( $obj );
  }

}