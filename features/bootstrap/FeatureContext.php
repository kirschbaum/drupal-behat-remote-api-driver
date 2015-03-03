<?php

use Behat\Behat\Context\ClosuredContextInterface,
    Behat\Behat\Context\TranslatedContextInterface,
    Behat\Behat\Context\BehatContext,
    Behat\Behat\Exception\PendingException;
use Behat\Gherkin\Node\PyStringNode,
    Behat\Gherkin\Node\TableNode;
use Drupal\DrupalExtension\Event\EntityEvent;

/**
 * Features context.
 */
class FeatureContext extends \Kirschbaum\DrupalBehatRemoteAPIDriver\DrupalRemoteContext
{
    /**
     * Initializes context.
     * Every scenario gets its own context object.
     *
     * @param array $parameters context parameters (set them up through behat.yml)
     */
    public function __construct(array $parameters)
    {
        parent::__construct($parameters);
    }

    /**
     * Hook into node creation to test `@beforeNodeCreate`
     *
     * @beforeNodeCreate
     */
    public function alterNodeParameters(EntityEvent $event) {
        // @see `features/drupalRemoteAPI.feature`
        // Change 'published on' to the expected 'created'.
        $node = $event->getEntity();
        if (isset($node->{"published on"})) {
            $node->created = $node->{"published on"};
            unset($node->{"published on"});
        }
    }

    /**
     * Hook into term creation to test `@beforeTermCreate`
     *
     * @beforeTermCreate
     */
    public function alterTermParameters(EntityEvent $event) {
        // @see `features/drupalRemoteAPI.feature`
        // Change 'Label' to expected 'name'.
        $term = $event->getEntity();
        if (isset($term->{'Label'})) {
            $term->name = $term->{'Label'};
            unset($term->{'Label'});
        }
    }

    /**
     * Hook into user creation to test `@beforeUserCreate`
     *
     * @beforeUserCreate
     */
    public function alterUserParameters(EntityEvent $event) {
        // @see `features/drupalRemoteAPI.feature`
        // Concatenate 'First name' and 'Last name' to form user name.
        $user = $event->getEntity();
        if (isset($user->{"First name"}) && isset($user->{"Last name"})) {
            $user->name = $user->{"First name"} . ' ' . $user->{"Last name"};
            unset($user->{"First name"}, $user->{"Last name"});
        }
        // Transform custom 'E-mail' to 'mail'.
        if (isset($user->{"E-mail"})) {
            $user->mail = $user->{"E-mail"};
            unset($user->{"E-mail"});
        }
    }

  /**
   * @Given /^I wait$/
   */
  public function iWait() {
    sleep(3);
  }
}
