<?php

class WTPHelper {

  /**
   * Clean up the body of a petition
   *
   * @param str $content The petition body
   * @return str
   */
  public static function cleanPetitionBody( $content ) {
    $content = trim( $content );
    return $content;
  }

  /**
   * Build our global WeThePeople JavaScript object, used to localize our scripts
   *
   * @return str
   */
  public static function getScriptLocalizationObject() {
    $obj = array(
      'paths' => array(
        'search' => action( 'PetitionController@search' )
      )
    );
    return json_encode( $obj );
  }

}