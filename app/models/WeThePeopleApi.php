<?php

class WeThePeopleApi {

  protected $api_key;

  const API_ENDPOINT = 'http://11111011100.api.whitehouse.gov/v1/';

  /**
   * Retrieve the API key and store it in $this->api_key
   *
   * @return str
   */
  public function getApiKey() {
    if ( $this->api_key === null ) {
      $this->api_key = Config::get( 'wethepeople.api_key' );
    }
    return $this->api_key;
  }

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
   * @param bool $force Force retrieval of the petition, bypassing the cache?
   * @return object
   *
   * @link https://petitions.whitehouse.gov/developers#petitions-retrieve
   */
  public function retrieve( $id, $force = false ) {
    $method = sprintf( 'petitions/%s', $id );
    return $this->api( $method, array(), 360, $force );
  }

  /**
   * Post a signature
   *
   * @param int $petition_id The Petition's wtp_id attribute
   * @param Signature object $signature The petition's signature
   * @return bool
   */
  public function signature( $petition_id, Signature $signature ) {
    $data = array(
      'petition_id' => $petition_id,
      'first_name' => $signature->first_name,
      'last_name' => $signature->last_name,
      'email' => $signature->email,
      'zip' => $signature->postal_code
    );
    $params = array(
      'headers' => array(
        'Accept' => 'application/json',
        'Accept-Encoding' => 'gzip',
        'Content-Type' => 'application/json',
      ),
      'body' => json_encode( $data )
    );


    $api = new \GuzzleHttp\Client();
    $uri = sprintf( '%ssignatures.json?api_key=%s', self::API_ENDPOINT, $this->getApiKey() );
    try {
      $response = $api->post( $uri, $params );
    } catch ( GuzzleHttp\Exception\ClientException $e ) {
      $response = $e->getResponse();
    }

    // Something's not okay
    if ( $response->getStatusCode() != 200 ) {
      throw new Exception( sprintf( 'We The People API returned status code of %d', $response->getStatusCode() ) );
    }
  }

  /**
   * Make a call to the We The People API
   *
   * @param str $method The API endpoint
   * @param array $args Arguments to pass to the API
   * @param int $cache_expiration The number of minutes to keep the results in the cache
   * @param bool $force Force an API call, bypassing the cache?
   * @return array
   */
  protected function api( $method, $args = array(), $cache_expiration = 60, $force = false ) {
    $use_cache = Config::get( 'wethepeople.cache_api_requests' );

    // Put them in alphabetical order so the cache keys will match later
    ksort( $args );

    // Build the cache key
    $key = sprintf( '%s_%s', $method, md5( http_build_query( $args ) ) );

    if ( $use_cache && Cache::has( $key ) && ! $force ) {
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