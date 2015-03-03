<?php namespace Kirschbaum\DrupalBehatRemoteAPIDriver\Tests;

use Kirschbaum\DrupalBehatRemoteAPIDriver\Client;
use VCR\VCR;

class TermTest extends BaseTest {

    /**
     * @test
     * @vcr should_create_term_with_vid_and_return_object_with_term_id.json
     */
    public function should_create_term_with_vid_and_return_object_with_term_id()
    {
        VCR::turnOn();
        VCR::insertCassette('should_create_term_with_vid_and_return_object_with_term_id.json');
        $client = new Client();
        $client->setOption('base_url', $this->url);
        $client->authenticate($this->username, $this->password, 'http_drupal_login');
        $results = $client->api('term')->termCreate($this->test_term_params());
        $this->assertObjectHasAttribute('tid', $results);
        VCR::eject();
        VCR::turnOff();
    }

    /**
     * @test
     * @vcr should_create_term_based_on_vocabulary_machine_name.json
     */
    public function should_create_term_based_on_vocabulary_machine_name()
    {
        VCR::turnOn();
        VCR::insertCassette('should_create_term_based_on_vocabulary_machine_name.json');
        $client = new Client();
        $client->setOption('base_url', $this->url);
        $client->authenticate($this->username, $this->password, 'http_drupal_login');
        $term = $this->test_term_params();
        unset($term->vid);
        $term->vocabulary_machine_name = 'tags';
        $results = $client->api('term')->termCreate($this->test_term_params());
        $this->assertObjectHasAttribute('tid', $results);
        VCR::eject();
        VCR::turnOff();
    }

    /**
     * @test
     * @vcr should_create_term_based_on_vocabulary_name.json
     */
    public function should_create_term_based_on_vocabulary_name()
    {
        VCR::turnOn();
        VCR::insertCassette('should_create_term_based_on_vocabulary_name.json');
        $client = new Client();
        $client->setOption('base_url', $this->url);
        $client->authenticate($this->username, $this->password, 'http_drupal_login');
        $term = $this->test_term_params();
        unset($term->vid);
        $term->vocabulary_machine_name = 'Tags';
        $results = $client->api('term')->termCreate($this->test_term_params());
        $this->assertObjectHasAttribute('tid', $results);
        VCR::eject();
        VCR::turnOff();
    }

    /**
     * @test
     * @vcr should_take_exception_when_term_vocabulary_machine_name_is_defined_but_does_not_exist.json
     * @expectedException \Kirschbaum\DrupalBehatRemoteAPIDriver\Exception\RuntimeException
     * @expectedExceptionMessage The vocabulary name provided ("Does Not Exist") did not match the name or machine_name of the remote site vocabularies.
     */
    public function should_take_exception_when_term_vocabulary_machine_name_is_defined_but_does_not_exist()
    {
        VCR::turnOn();
        VCR::insertCassette('should_take_exception_when_term_vocabulary_machine_name_is_defined_but_does_not_exist.json');
        $client = new Client();
        $client->setOption('base_url', $this->url);
        $client->authenticate($this->username, $this->password, 'http_drupal_login');
        $term = $this->test_term_params();
        unset($term->vid);
        $term->vocabulary_machine_name = 'Does Not Exist';
        $term = $client->api('term')->termCreate($term);
        VCR::eject();
        VCR::turnOff();
    }

    /**
     * @test
     * @vcr should_delete_term_and_return_empty_array.json
     */
    public function should_delete_term_and_return_empty_array()
    {
        VCR::turnOn();
        VCR::insertCassette('should_create_term_and_return_object_with_term_id.json');
        $client = new Client();
        $client->setOption('base_url', $this->url);
        $client->authenticate($this->username, $this->password, 'http_drupal_login');
        $term = $client->api('term')->termCreate($this->test_term_params());
        $this->assertObjectHasAttribute('tid', $term);
        VCR::eject();
        VCR::turnOff();

        VCR::turnOn();
        VCR::insertCassette('should_delete_term_and_return_empty_array.json');
        $client = new Client();
        $client->setOption('base_url', $this->url);
        $client->authenticate($this->username, $this->password, 'http_drupal_login');
        $results = $client->api('term')->termDelete($term);
        $this->assertEmpty($results);
        VCR::eject();
        VCR::turnOff();
    }



}