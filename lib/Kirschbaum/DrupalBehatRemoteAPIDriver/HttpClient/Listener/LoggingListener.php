<?php

namespace Kirschbaum\DrupalBehatRemoteAPIDriver\HttpClient\Listener;

use Guzzle\Common\Event;
use Kirschbaum\DrupalBehatRemoteAPIDriver\Client;
use Kirschbaum\DrupalBehatRemoteAPIDriver\Exception\RuntimeException;
use Guzzle\Log\MonologLogAdapter;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

class LoggingListener
{
    /**
     * @var Logger
     */
    protected $logger;

    public function __construct()
    {

    }

    public function onRequestBeforeSend(Event $event)
    {
        $request = $event['request'];

        $this->getLogger($request);
    }

    public function getLogger($message)
    {
        if($this->logger == null)
            $this->setLogger();
        $this->logger->addInfo($message);
    }

    public function setLogger($logger = null)
    {
        if($logger == null) {
            $logger = new Logger('drupal_remote_client');
            $logger->pushHandler(new StreamHandler('/tmp/drupal_remote_client.log', Logger::INFO));
        }

        $this->logger = $logger;
    }
}
