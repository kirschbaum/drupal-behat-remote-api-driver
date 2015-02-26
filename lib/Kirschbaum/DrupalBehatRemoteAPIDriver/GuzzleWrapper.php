<?php namespace Kirschbaum\DrupalBehatRemoteAPIDriver;

use Guzzle\Http\Message\RequestInterface;

class GuzzleWrapper extends \Guzzle\Http\Client implements DrupalRemoteAPIClientInterface {

    /**
     * Tried a few other ways to set these but could not
     */
    protected function prepareRequest(RequestInterface $request, array $options = array())
    {
        parent::prepareRequest($request, $options);

        $request->getCurlOptions()->set(CURLOPT_SSL_VERIFYHOST, false);
        $request->getCurlOptions()->set(CURLOPT_SSL_VERIFYPEER, false);

        return $request;
    }

} 