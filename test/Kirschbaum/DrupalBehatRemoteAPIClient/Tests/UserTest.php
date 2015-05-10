<?php namespace Kirschbaum\DrupalBehatRemoteAPIDriver\Tests;

use Kirschbaum\DrupalBehatRemoteAPIDriver\Client;
use VCR\VCR;

class UserTest extends BaseTest {

  /**
   * @test
   * @vcr should_create_and_delete_user_and_return_empty_array.json
   */
  public function should_create_and_delete_user_and_return_empty_array()
  {
    VCR::insertCassette('should_create_user_and_return_user_id.json');
    $client = new Client();
    $client->setOption('base_url', $this->url);
    $client->authenticate($this->username, $this->password, 'http_drupal_login');
    $user = $client->api('user')->userCreate($this->test_user_params());
    $this->assertObjectHasAttribute('uid', $user);
    $this->assertNotNull($user->uid);

    VCR::insertCassette('should_add_role_to_user.json');
    $client = new Client();
    $client->setOption('base_url', $this->url);
    $client->authenticate($this->username, $this->password, 'http_drupal_login');
    $results2 = $client->api('user')->userAddRole($user, 'authenticated user');
    $this->assertEquals('Role successfully added', $results2['message']);

    VCR::insertCassette('should_create_and_delete_user_and_return_empty_array.json');
    $client = new Client();
    $client->setOption('base_url', $this->url);
    $client->authenticate($this->username, $this->password, 'http_drupal_login');
    $results3 = $client->api('user')->userDelete($user);
    $this->assertEmpty($results3);
  }

}