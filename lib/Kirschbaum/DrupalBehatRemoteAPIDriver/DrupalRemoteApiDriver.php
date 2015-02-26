<?php
/**
 * Created by PhpStorm.
 * User: alfrednutile
 * Date: 1/16/15
 * Time: 2:28 PM
 */

namespace Kirschbaum\DrupalBehatRemoteAPIDriver;


use Drupal\Component\Utility\Random;
use Drupal\Drupal;

class DrupalRemoteApiDriver extends Drupal {

    public function __construct(array $drivers = array(), Random $random) {

        $this->registerDriver('drupal_remote_api', new \Kirschbaum\DrupalBehatRemoteAPIDriver\Drivers\DrupalBehatRemoteApiDriver());
        $this->random = $random;
    }
} 