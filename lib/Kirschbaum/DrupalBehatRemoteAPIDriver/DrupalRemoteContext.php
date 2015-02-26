<?php namespace Kirschbaum\DrupalBehatRemoteAPIDriver;


use Behat\Gherkin\Node\TableNode;
use Drupal\DrupalExtension\Context\DrupalContext;

class DrupalRemoteContext extends DrupalContext {

    protected $drupal_remote_base_url;
    protected $drupal_filter_format;
    protected $custom_data_tables;

    public function __construct($parameters = array())
    {
        $this->drupal_remote_base_url = $parameters['base_url'];
    }

    /**
     * Get active Drupal Driver.
     * Overriding parent method to set Drupal Remote Parameters on remote client.
     */
    public function getDriver($name = 'drupal_remote_api')
    {
        $driver = $this->getDrupal()->getDriver($name);
        $driver->setDrupalRemoteParameters($this->getDrupalParameter('drupal_remote_api'));
        $driver->setBaseUrlForRemoteClient($this->drupal_remote_base_url);
        $driver->setDrupalFilterFormat($this->drupal_filter_format);
        $driver->setCustomDataTables($this->custom_data_tables);
        return $driver;
    }

    /**
     * @Given /^I dump out path$/
     */
    public function iDumpOutPath()
    {
        $this->printDebug($this->locatePath('/node'));
    }

    /**
     * @Given /^The default filter format of "([^"]*)"$/
     */
    public function theDefaultTextFormatOf($arg1)
    {
        $this->drupal_filter_format = $arg1;
    }

    /**
     * @Given /^the fieldset "([^"]*)" with the tabs:$/
     */
    public function theFieldsetWithTheTabs($arg1, TableNode $table)
    {
        $this->custom_data_tables[$arg1] = $table;
    }

    /**
     * @Given /^the fieldset "([^"]*)" with the options:$/
     */
    public function theFieldsetWithTheOptions($arg1, TableNode $table)
    {
        $this->custom_data_tables[$arg1] = $table;
    }

} 
