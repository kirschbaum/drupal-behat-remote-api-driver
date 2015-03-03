<?php namespace Kirschbaum\DrupalBehatRemoteAPIDriver\Tests;

class BaseTest extends \PHPUnit_Framework_TestCase {

    protected $url;
    protected $username;
    protected $password;

    function setUp()
    {
        $this->url = getenv('DRUPAL_REMOTE_CLIENT_URL');
        $this->username = getenv('DRUPAL_REMOTE_CLIENT_USERNAME');
        $this->password = getenv('DRUPAL_REMOTE_CLIENT_PASSWORD');
    }

    public function test_node_params()
    {
        $node = new \stdClass();
        $node->type = 'Article';
        $node->title = 'A great test title';
        $node->body = 'The best body text ever!';
        return $node;
    }

    public function test_user_params()
    {
        $user = new \stdClass();
        $user->name = 'yQhus21u';
        $user->pass = 'fM4VDk5aK0sg4zcD';
        $user->role = 'authenticated user';
        $user->mail = 'test@example.com';
        return $user;
    }

    public function test_term_params()
    {
        $term = new \stdClass();
        $term->name = 'My Term';
        $term->description = 'My term description';
        $term->vid = 1;
        return $term;
    }

} 