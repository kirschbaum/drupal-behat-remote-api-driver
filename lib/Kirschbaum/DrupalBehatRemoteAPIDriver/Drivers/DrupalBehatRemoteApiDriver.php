<?php namespace Kirschbaum\DrupalBehatRemoteAPIDriver\Drivers;

use Kirschbaum\DrupalBehatRemoteAPIDriver\Client;
use Kirschbaum\DrupalBehatRemoteAPIDriver\Exception\RuntimeException;
use Drupal\Driver\BaseDriver;
use Drupal\Driver\DriverInterface;
use Drupal\Exception\BootstrapException,
    Drupal\DrupalExtension\Context\DrupalSubContextFinderInterface;

use Kirschbaum\DrupalBehatRemoteAPIDriver\Client as DrupalRemoteClient;
use Behat\Behat\Exception\PendingException;

/**
 * Fully bootstraps Drupal and uses native API calls.
 */
class DrupalBehatRemoteApiDriver extends BaseDriver {

    /**
     * @var DrupalRemoteClient
     */
    private $drupal_remote_client;

    /**
     * @var Remote Site Username
     */
    private $remote_site_username;

    /**
     * @var Remote Site Password
     */
    private $remote_site_password;

    /**
     * @var Remote Site URL
     */
    private $remote_site_url;

    /**
     * @var BaseUrlForRemoteClient
     */
    private $base_url_for_remote_client;

    /**
     * @var DrupalFilterFormat
     */
    private $drupal_filter_format;

    /**
     * @var CustomDataTables
     */
    private $custom_data_tables;

    /**
     * @var Request Cookie
     */
    private $request_cookie;

    /**
     * @var Custom Formatter Class
     */
    private $custom_formatter_class;


    public function __construct(DrupalRemoteClient $drupal_remote_client = null)
    {
        $this->drupal_remote_client = $drupal_remote_client;
    }

    /**
     * Implements DriverInterface::isBootstrapped().
     */
    public function isBootstrapped() {
        return TRUE;
    }

    /**
     * Implements DriverInterface::createNode().
     * @param object $node
     * @return object|void
     * @throws \Exception
     */
    public function createNode($node) {
        try {
            $nodeRequest = $this->getDrupalRemoteClient()->api('node');
            $nodeRequest->setDrupalFilterFormat($this->drupal_filter_format);
            $nodeRequest->setCustomDataTables($this->custom_data_tables);
            $nodeRequest->setCustomFormatterClass($this->custom_formatter_class);
            return $nodeRequest->createNode($node);
        }
        catch(\Exception $e) {
            throw new RuntimeException(sprintf('Remote API Exception: %s', $e->getMessage()));
        }
    }

    /**
     * Implements DriverInterface::nodeDelete().
     * @param object $node
     */
    public function nodeDelete($node)
    {
        try {
            $this->getDrupalRemoteClient()->api('node')->deleteNode($node);
        } catch (\Exception $e) {
            throw new RuntimeException($e->getMessage());
        }
    }

    /**
     * Implements DriverInterface::userCreate().
     */
    public function userCreate(\stdClass $user) {
        try {
            return $this->getDrupalRemoteClient()->api('user')->userCreate($user);
        } catch (\Exception $e) {
            throw new RuntimeException($e->getMessage());
        }
    }

    /**
     * Implements DriverInterface::userDelete().
     */
    public function userDelete(\stdClass $user) {
        try {
            $this->getDrupalRemoteClient()->api('user')->userDelete($user);
        } catch (\Exception $e) {
            throw new RuntimeException($e->getMessage());
        }
    }

    public function userAddRole(\stdClass $user, $role_name) {
        try {
            $this->getDrupalRemoteClient()->api('user')->userAddRole($user, $role_name);
        } catch (\Exception $e) {
            throw new RuntimeException($e->getMessage());
        }
    }

    /**
     * Implements DriverInterface::termCreate().
     */
    public function createTerm(\stdClass $term) {
        try {
            return $this->getDrupalRemoteClient()->api('term')->termCreate($term);
        } catch (\Exception $e) {
            throw new RuntimeException($e->getMessage());
        }
    }

    /**
     * Implements DriverInterface::termDelete().
     */
    public function termDelete(\stdClass $term) {
        try {
            $this->getDrupalRemoteClient()->api('term')->termDelete($term);
        } catch (\Exception $e) {
            throw new RuntimeException($e->getMessage());
        }
    }

    public function processBatch() {
        // This is needed for afterScenerio() cleanup.
        // Seems required to cleanup multiple users.
    }

    public function clearCache($type = NULL)
    {
        try {
            $this->getDrupalRemoteClient()->api('cache')->clearCache($type);
        } catch (\Exception $e) {
            throw new RuntimeException($e->getMessage());
        }
    }

    /**
     * @return DrupalRemoteClient
     */
    public function getDrupalRemoteClient()
    {
        if($this->drupal_remote_client == null)
            $this->setDrupalRemoteClient();
        return $this->drupal_remote_client;
    }

    /**
     * @param DrupalRemoteClient $drupal_remote_client
     */
    public function setDrupalRemoteClient($drupal_remote_client = null)
    {
        if($drupal_remote_client == null)
        {
            $drupal_remote_client = $this->instantiateNewClient();
        }
        $this->drupal_remote_client = $drupal_remote_client;
    }

    /**
     * @return mixed
     */
    public function getBaseUrlForRemoteClient()
    {
        return $this->base_url_for_remote_client;
    }

    /**
     * @param mixed $base_url_for_remote_client
     */
    public function setBaseUrlForRemoteClient($base_url_for_remote_client)
    {
        $this->base_url_for_remote_client = urldecode($base_url_for_remote_client);
    }

    public function setDrupalFilterFormat($field_format)
    {
        $this->drupal_filter_format = $field_format;
    }

    public function setCustomDataTables($tables)
    {
        $this->custom_data_tables = $tables;
    }

    public function setDrupalRemoteParameters($parameters)
    {
        $this->remote_site_username   = (isset($parameters['login_username'])) ? $parameters['login_username'] : NULL;
        $this->remote_site_password   = (isset($parameters['login_password'])) ? $parameters['login_password'] : NULL;
        $this->request_cookie         = (isset($parameters['request_cookie'])) ? $parameters['request_cookie'] : NULL;
        $this->custom_formatter_class = (isset($parameters['custom_formatter_class'])) ? $parameters['custom_formatter_class'] : NULL;
    }

    protected function instantiateNewClient()
    {
        $drupalPassword  = ($this->remote_site_password) ? $this->remote_site_password : getenv('DRUPAL_REMOTE_CLIENT_PASSWORD');
        $drupalUser      = ($this->remote_site_username) ? $this->remote_site_username : getenv('DRUPAL_REMOTE_CLIENT_USERNAME');
        $drupalUrl       = ($this->base_url_for_remote_client) ? $this->base_url_for_remote_client : getenv('DRUPAL_REMOTE_CLIENT_URL');
        $drupalRemoteClient = new Client();
        $drupalRemoteClient->setOption('base_url', $drupalUrl);
        $drupalRemoteClient->authenticate($drupalUser, $drupalPassword, 'http_drupal_login', $this->request_cookie);
        //  @TODO - Make logging optional
        $drupalRemoteClient->logging();
        return $drupalRemoteClient;
    }

}
