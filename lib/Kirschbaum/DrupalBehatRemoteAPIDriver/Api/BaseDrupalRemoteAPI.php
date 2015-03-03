<?php namespace Kirschbaum\DrupalBehatRemoteAPIDriver\Api;

use Kirschbaum\DrupalBehatRemoteAPIDriver\Exception\DrupalResponseCodeException;
use Kirschbaum\DrupalBehatRemoteAPIDriver\Exception\DrupalResponseException;

class BaseDrupalRemoteAPI extends AbstractApi {

  protected function confirmResponseStatusCodeIs200($response) {
    // Checking for response ID because RestWS does not return status code.
    // @TODO Add status code to RestWS response.
    if(!isset($response['id']) && $response['response_code'] != 200){
      throw new DrupalResponseCodeException(sprintf('Remote API Exception: %s', $response['message']));
    }
  }

  protected function confirmRestWSFilterResponse($response) {
    if(!isset($response['list'])){
      throw new DrupalResponseCodeException(sprintf('Remote API Exception: RestWS filter list not present: %s', $response));
    }
  }

  protected function confirmDeletedResponse($result)
  {
    if($result != array()){
      throw new DrupalResponseException(sprintf('Remote API Exception: Deletion has failed: %s', $result));
    }
  }

}