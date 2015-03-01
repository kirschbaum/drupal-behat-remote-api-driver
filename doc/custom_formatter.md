## Add A Custom Formatter
[Back to the navigation](https://github.com/kirschbaum/drupal-behat-remote-api-driver#documentation)

There may be times when the Drupal field data you are trying to store through the remote API isn't formatted the way the client drupal module expects. This shouldn't happen for the typical Drupal site. However, if you run into a situation where a custom field type is giving you a problem, here is how you can modify and format the data correctly without modifying this library.

**Side Note:** If you think whatever problem you are solving with this formatter should be part of the core library, just open up a support request and we can consider adding it.

### Solution

Create a new class in your project (you can store it wherever you want, just make sure it gets autoloaded). The class should implement Kirschbaum\DrupalBehatRemoteAPIDriver\CustomFormatterInterface:

```
<?php namespace DrupalRemoteAPI;

use Kirschbaum\DrupalBehatRemoteAPIDriver\CustomFormatterInterface;

class FieldFormatter implements CustomFormatterInterface {

    /**
     * Process custom Drupal data formats
     *
     * @param $info The field info for the current field in question.
     * @param $new_entity The node object being built up and formatted prior to the request.
     * @param $param The field machine name.
     * @param $column The first defined column for the field in question.
     * @param $value The value for the field in question.
     * @param $custom_data_tables Array of table objects added by custom steps.
     * @return Response The updated node object.
     * @throws \Exception
     */
    public function process($info, $new_entity, $param, $column, $value, $custom_data_tables)
    {

        // Do any necessary formatting here. See example below.

        return $new_entity;

    }

}

```

In order for the library to know to include your custom formatter we need to add the "custom_formatter_class" to the behat.yml file:

```
      Kirschbaum\DrupalBehatRemoteAPIDriver\DrupalRemoteExtension:
        blackbox: ~
        api_driver: 'drupal_remote_api'
        drupal_remote_api:
          login_username: 'drupal_username'
          login_password: 'drupal_password'
          custom_formatter_class: '\DrupalRemoteAPI\FieldFormatter'
        default_driver: 'drupal_remote_api'

```

### Example Problem

The JQuery Tabs Field module implements a custom Drupal field. Unlike typical Drupal fields, this module creates a new field with many columns. 
