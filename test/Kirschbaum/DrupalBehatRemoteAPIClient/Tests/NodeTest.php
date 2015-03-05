<?php namespace Kirschbaum\DrupalBehatRemoteAPIDriver\Tests;

use Kirschbaum\DrupalBehatRemoteAPIDriver\Client;
use VCR\VCR;

class NodeTest extends BaseTest {

    /**
     * @test
     * @vcr should_create_node_and_return_object_with_node_id.json
     */
    public function should_create_node_and_return_object_with_node_id()
    {
        VCR::turnOn();
        VCR::insertCassette('should_create_node_and_return_object_with_node_id.json');
        $client = new Client();
        $client->setOption('base_url', $this->url);
        $client->authenticate($this->username, $this->password, 'http_drupal_login');
        $results = $client->api('nodes')->createNode($this->test_node_params());
        $this->assertObjectHasAttribute('nid', $results);
        VCR::eject();
        VCR::turnOff();
    }

    /**
     * @test
     * @vcr should_delete_node_and_return_empty_array.json
     */
    public function should_delete_node_and_return_empty_array()
    {
        VCR::turnOn();
        VCR::insertCassette('should_create_node_and_return_object_with_node_id.json');
        $client = new Client();
        $client->setOption('base_url', $this->url);
        $client->authenticate($this->username, $this->password, 'http_drupal_login');
        $nodeResponse = $client->api('nodes')->createNode($this->test_node_params());
        $this->assertObjectHasAttribute('nid', $nodeResponse);
        VCR::eject();
        VCR::turnOff();

        VCR::turnOn();
        VCR::insertCassette('should_delete_node_and_return_empty_array.json');
        $client = new Client();
        $client->setOption('base_url', $this->url);
        $client->authenticate($this->username, $this->password, 'http_drupal_login');
        $results = $client->api('nodes')->deleteNode($nodeResponse);
        $this->assertEmpty($results);
        VCR::eject();
        VCR::turnOff();
    }

    /**
     * @test
     * @vcr should_create_node_and_return_object_with_node_id.json
     * @expectedException \Kirschbaum\DrupalBehatRemoteAPIDriver\Exception\FilterFormatException
     */
    public function should_take_exception_when_test_sets_field_format_that_doesnt_exist()
    {
        VCR::turnOn();
        VCR::insertCassette('should_take_exception_when_test_sets_field_format_that_doesnt_exist.json');
        $client = new Client();
        $client->setOption('base_url', $this->url);
        $client->authenticate($this->username, $this->password, 'http_drupal_login');
        $nodeRequest = $client->api('nodes');
        $nodeRequest->setDrupalFilterFormat('non_existent');
        $results = $nodeRequest->createNode($this->test_node_params());
        VCR::eject();
        VCR::turnOff();
    }

    /**
     * @test
     * @vcr should_take_exception_when_incorrect_credentials_are_provided.json
     * @expectedException \Kirschbaum\DrupalBehatRemoteAPIDriver\Exception\DrupalResponseCodeException
     * @expectedExceptionMessage Remote API Exception: Remote site login has failed. Check the username and password you provided.
     */
    public function should_take_exception_when_incorrect_credentials_are_provided()
    {
        VCR::turnOn();
        VCR::insertCassette('should_take_exception_when_incorrect_credentials_are_provided.json');
        $client = new Client();
        $client->setOption('base_url', $this->url);
        $pw = 'wrong';
        $client->authenticate($this->username, $pw, 'http_drupal_login');
        $nodeRequest = $client->api('nodes');
        $results = $nodeRequest->createNode($this->test_node_params());
        VCR::eject();
        VCR::turnOff();
    }

    /**
     * @test
     * @vcr should_take_exception_when_too_many_terms_are_provided.json
     * @expectedException \Kirschbaum\DrupalBehatRemoteAPIDriver\Exception\RuntimeException
     * @expectedExceptionMessage The field_tags field on the remote site requires no more than 1 terms. 2 were provided.
     */
    public function should_take_exception_when_too_many_terms_are_provided()
    {
        VCR::turnOn();
        VCR::insertCassette('should_take_exception_when_too_many_terms_are_provided.json');
        $client = new Client();
        $client->setOption('base_url', $this->url);
        $client->authenticate($this->username, $this->password, 'http_drupal_login');
        $nodeRequest = $client->api('nodes');
        $node = $this->test_node_params();
        $node->field_tags = 'Tag one, Tag two';
        $results = $nodeRequest->createNode($node);
        VCR::eject();
        VCR::turnOff();
    }

}