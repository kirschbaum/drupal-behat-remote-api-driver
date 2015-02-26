<?php namespace Kirschbaum\DrupalBehatRemoteAPIDriver\Api;

class Cache extends BaseDrupalRemoteAPI {

    public function clearCache($type)
    {
        $response = $this->get('/drupal-remote-api/cache');
        $this->confirmResponseStatusCodeIs200($response);
    }

}