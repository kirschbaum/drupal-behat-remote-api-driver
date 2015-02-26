<?php

namespace Kirschbaum\DrupalBehatRemoteAPIDriver\Api;

use Kirschbaum\DrupalBehatRemoteAPIDriver\Client;

/**
 * Api interface
 *
 */
interface ApiInterface
{
    public function __construct(Client $client);

    public function getPerPage();

    public function setPerPage($perPage);
}
