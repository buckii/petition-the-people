<?php

class WeThePeopleApi {

  const API_ENDPOINT = 'https://api.whitehouse.gov/v1/';

  /**
   * Search petitions (by title)
   *
   * @param str $term The search term
   * @param array $args Additional arguments to pass to the API
   * @return array
   *
   * @link https://petitions.whitehouse.gov/developers#petitions-index
   */
  public function search( $term, $args = array() ) {
    $defaults = array(
      'limit' => 25,
      'status' => 'open'
    );
    $args = array_merge( $defaults, $args );

    // Add the search term
    $args['title'] = strtolower( $term );

    return $this->api( 'petitions', $args, 60 );
  }

  /**
   * Retrieve a single petition object
   *
   * @param int $id The petition ID
   * @return object
   *
   * @link https://petitions.whitehouse.gov/developers#petitions-retrieve
   */
  public function retrieve( $id ) {
    $method = sprintf( 'petitions/%s', $id );
    return $this->api( $method, array(), 360 );
  }

  /**
   * Make a call to the We The People API
   *
   * @param str $method The API endpoint
   * @param array $args Arguments to pass to the API
   * @param int $cache_expiration The number of minutes to keep the results in the cache
   * @return array
   */
  protected function api( $method, $args = array(), $cache_expiration = 60 ) {
    $use_cache = Config::get( 'wethepeople.cache_api_requests' );

    // Put them in alphabetical order so the cache keys will match later
    ksort( $args );

    // Build the cache key
    $key = sprintf( '%s_%s', $method, md5( http_build_query( $args ) ) );

    if ( $use_cache && Cache::has( $key ) ) {
      $response = Cache::get( $key );

    } else {
      $api = new \GuzzleHttp\Client();
      $uri = sprintf( '%s%s.json?%s', self::API_ENDPOINT, $method, http_build_query( $args ) );
      $response = $api->get( $uri );

      // Something's not okay
      if ( $response->getStatusCode() != 200 ) {
        throw new Exception( sprintf( 'We The People API returned status code of %d', $response->getStatusCode() ) );
      }

      // Store the value in cache
      if ( $use_cache ) {
        Cache::add( $key, $response, $cache_expiration );
      }
    }

    return json_decode( $response->getBody(), false );
  }
}