<?php namespace Kirschbaum\DrupalBehatRemoteAPIDriver;

use Drupal\DrupalExtension\Extension;
use Symfony\Component\DependencyInjection\ContainerBuilder,
    Symfony\Component\DependencyInjection\Loader\YamlFileLoader,
    Symfony\Component\Config\FileLocator,
    Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;

use Behat\Behat\Extension\ExtensionInterface;

class DrupalRemoteExtension extends Extension {

    public function load(array $config, ContainerBuilder $container) {

        $loader = new YamlFileLoader($container, new FileLocator(__DIR__ . '/config'));
        $loader->load('services.yml');
        $container->setParameter('drupal.drupal.default_driver', 'drupal_remote_api');


        // Store config in parameters array to be passed into the DrupalContext.
        $drupal_parameters = array();
        foreach ($config as $key => $value) {
            $drupal_parameters[$key] = $value;
        }
        $container->setParameter('drupal.parameters', $drupal_parameters);

        $container->setParameter('drupal.region_map', $config['region_map']);

    }

    /**
     * Setup configuration for this extension.
     *
     * @param ArrayNodeDefinition $builder
     *   ArrayNodeDefinition instance.
     */
    public function getConfig(ArrayNodeDefinition $builder) {
        $builder->
        children()->
        arrayNode('basic_auth')->
        children()->
        scalarNode('username')->end()->
        scalarNode('password')->end()->
        end()->
        end()->
        scalarNode('default_driver')->
        defaultValue('blackbox')->
        info('Use "blackbox" to test remote site. See "api_driver" for easier integration.')->
        end()->
        scalarNode('api_driver')->
        defaultValue('drush')->
        info('Bootstraps drupal through "drupal8" or "drush".')->
        end()->
        scalarNode('drush_driver')->
        defaultValue('drush')->
        end()->
        arrayNode('region_map')->
        info("Targeting content in specific regions can be accomplished once those regions have been defined." . PHP_EOL
            . '  My region: "#css-selector"' . PHP_EOL
            . '  Content: "#main .region-content"'. PHP_EOL
            . '  Right sidebar: "#sidebar-second"'. PHP_EOL
        )->
        useAttributeAsKey('key')->
        prototype('variable')->
        end()->
        end()->
        arrayNode('text')->
        info(
            'Text strings, such as Log out or the Username field can be altered via behat.yml if they vary from the default values.' . PHP_EOL
            . '  log_out: "Sign out"' . PHP_EOL
            . '  log_in: "Sign in"' . PHP_EOL
            . '  password_field: "Enter your password"' . PHP_EOL
            . '  username_field: "Nickname"'
        )->
        addDefaultsIfNotSet()->
        children()->
        scalarNode('log_in')->
        defaultValue('Log in')->
        end()->
        scalarNode('log_out')->
        defaultValue('Log out')->
        end()->
        scalarNode('password_field')->
        defaultValue('Password')->
        end()->
        scalarNode('username_field')->
        defaultValue('Username')->
        end()->
        end()->
        end()->
        arrayNode('selectors')->
        children()->
        scalarNode('message_selector')->end()->
        scalarNode('error_message_selector')->end()->
        scalarNode('success_message_selector')->end()->
        scalarNode('warning_message_selector')->end()->
        end()->
        end()->
        // Drupal drivers.
        arrayNode('blackbox')->
        end()->
        arrayNode('drupal')->
        children()->
        scalarNode('drupal_root')->end()->
        end()->
        end()->
        arrayNode('drush')->
        children()->
        scalarNode('alias')->end()->
        scalarNode('binary')->defaultValue('drush')->end()->
        scalarNode('root')->end()->
        scalarNode('global_options')->end()->
        end()->
        end()->
        arrayNode('drupal_remote_api')->
        children()->
        scalarNode('login_username')->end()->
        scalarNode('login_password')->end()->
        scalarNode('request_cookie')->end()->
        scalarNode('custom_formatter_class')->end()->
        end()->
        end()->
        // Subcontext paths.
        arrayNode('subcontexts')->
        info(
            'The Drupal Extension is capable of discovering additional step-definitions provided by subcontexts.' . PHP_EOL
            . 'Module authors can provide these in files following the naming convention of foo.behat.inc. Once that module is enabled, the Drupal Extension will load these.' . PHP_EOL
            . PHP_EOL
            . 'Additional subcontexts can be loaded by either placing them in the bootstrap directory (typically features/bootstrap) or by adding them to behat.yml.'
        )->
        addDefaultsIfNotSet()->
        children()->
        arrayNode('paths')->
        info(
            '- /path/to/additional/subcontexts' . PHP_EOL
            . '- /another/path'
        )->
        useAttributeAsKey('key')->
        prototype('variable')->end()->
        end()->
        scalarNode('autoload')->
        defaultValue(TRUE)->
        end()->
        end()->
        end()->
        end()->
        end();
    }

} 