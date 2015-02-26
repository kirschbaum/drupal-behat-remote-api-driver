<?php namespace Kirschbaum\DrupalBehatRemoteAPIDriver\Api;

use Kirschbaum\DrupalBehatRemoteAPIDriver\Exception\DrupalResponseCodeException;

class BaseDrupalRemoteAPI extends AbstractApi {

  protected function confirmResponseStatusCodeIs200($response) {
    // Checking for response ID because RestWS does not return status code.
    // @TODO Add status code to RestWS response.
    if(!isset($response['id']) && $response['response_code'] != 200){
      throw new DrupalResponseCodeException(sprintf('Remote API Exception: %s', $response['message']));
    }
  }

}