<?php namespace Kirschbaum\DrupalBehatRemoteAPIDriver\Tests;

use Kirschbaum\DrupalBehatRemoteAPIDriver\Drivers\DrupalBehatRemoteApiDriver;

class DrupalRemoteApiDriverTest extends BaseTest {

    /**
     * @test
     */
    public function is_bootstrapped_should_return_true()
    {
        $driver = new DrupalBehatRemoteApiDriver();
        $result = $driver->isBootstrapped();
        $this->assertEquals(TRUE, $result);
    }

    /**
     * @test
     */
    public function get_drupal_remote_client_should_set_new_client_when_none_exists()
    {
        $driver = new DrupalBehatRemoteApiDriver();
        $client = $driver->getDrupalRemoteClient();
        $this->assertInstanceOf('Kirschbaum\DrupalBehatRemoteAPIDriver\Client', $client);
    }

    /**
     * @test
     */
    public function base_url_should_be_decoded_for_guzzle_requests()
    {
        $driver = new DrupalBehatRemoteApiDriver();
        $driver->setBaseUrlForRemoteClient('http//:test123:test%40123@test.com');
        $url = $driver->getBaseUrlForRemoteClient();
        $this->assertEquals('http//:test123:test@123@test.com', $url);
    }



}