## Add A Custom Formatter
[Back to the navigation](https://github.com/kirschbaum/drupal-behat-remote-api-driver#documentation)

There may be times when the Drupal field data you are trying to store through the remote API isn't formatted the way the client drupal module expects. This shouldn't happen for the typical Drupal site. However, if you run into a situation where a custom field type is giving you a problem, here is how you can modify and format the data correctly without modifying this library.

**Side Note:** If you think whatever problem you are solving with this formatter should be part of the core library, just open up a support request and we can consider adding it.

### Solution

Create a new class in your project (you can store it wherever you want, just make sure it gets autoloaded). The class should implement Kirschbaum\DrupalBehatRemoteAPIDriver\CustomFormatterInterface:

```php
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

```yml
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

The [JQuery Tabs Field module](https://www.drupal.org/project/field_jquery_tabs) implements a custom Drupal field. Unlike typical Drupal fields, this module creates a field that has 20+ columns. The remote API driver has no idea how this data should be formatted. Let's fix it, with a custom formatter:

```php
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

        // Special handling for jQuery Tabs Field.
        // We're only going to do something if the field belongs to the field_jquery_tabs module
        if ('field_jquery_tabs' === $info['module']) {
            // We only want to take action if custom_data_tables were provided by the tester in the form of custom steps.
            if(isset($custom_data_tables[$param])){
                $table = $custom_data_tables[$param];
                $row_count = 0;
                // For each custom field that was provided, we format it as RestWS requires.
                foreach ($table->getRows() as $row) 
                {
                    $new_entity->{$param}['tab_title_'.$row_count] = $row[0];
                    $new_entity->{$param}['tab_body_'.$row_count]  = $row[1];
                    $row_count++;
                }
            } else {
                // If the field exists but the custom data wasn't provided, we let folks know how to fix it.
                throw new \Exception(sprintf('Tab data not set for field "%s". There is a custom step to set tab data for this field.', $param));
            }
        }

        return $new_entity;

    }

}
```
