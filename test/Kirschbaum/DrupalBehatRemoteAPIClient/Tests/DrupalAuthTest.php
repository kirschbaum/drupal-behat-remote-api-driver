<?php namespace Kirschbaum\DrupalBehatRemoteAPIDriver\Tests;

use VCR\VCR;
use Kirschbaum\DrupalBehatRemoteAPIDriver\Client;

class DrupalAuthTest extends BaseTest {

    /**
     * @test
     * @vcr should_pass_basic_auth_and_drupal_auth_with_username_and_password.json
     */
    public function should_pass_basic_auth_and_drupal_auth_with_username_and_password()
    {
        $client = new Client();
        $client->setOption('base_url', $this->url);
        $client->authenticate($this->username, $this->password, 'http_drupal_login');
        $results = $client->api('nodes')->createNode($this->test_node_params());
        $this->assertObjectHasAttribute('nid', $results);
    }

} 