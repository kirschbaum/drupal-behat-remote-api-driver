
## Drupal Remote API Driver

The remote API driver extends the popular [Drupal Extention](https://github.com/jhedstrom/drupalextension) library to support running authenticated Behat tests against remote Drupal sites. Please note that there are two main components to this project:

1. The Drupal Remote API Driver - This extends the existing functionality of the drupalextention project and translates supported steps (e.g. create nodes, users, etc.) into appropriate REST requests to the remote Drupal site. See "currently supported features" below. This component is only required on the site where tests will be initiated.
2. The Drupal Remote API Client - This is a drupal module that leveradges the RestWS module and adds various helper functionality that the driver needs in order to work propertly. It is only required on the remote sites that will be tested.

If you are not already familiar with Behat or the [Drupal Extention](https://github.com/jhedstrom/drupalextension) library, you might want to head on over and review the [extensive documentation](https://behat-drupal-extension.readthedocs.org). This package leveradges Behat version 2 and DrupalExtention version 1.

## Documentation

Full documentation is coming soon.


## Testing Drupal Sites

Important: The remote API driver (this package) only needs to be installed on the site where tests will be initiated. The actual sites you will be testing do not require the driver. Instead, they will require the Drupal Remote API Client module to be installed and configured.


## Features 

Currently Supported:

* Drupal 7
* Node creation / deletion / cleanup
* User creation / deletion / cleanup
* Add existing user role to new user
* Set custom filter format based on tester defined preference or default from remote site
* Support for custom fields and tabular data
* Drupal Authentication for Remote Site
* Basic Auth
* Adding custom cookie to request header
* Clear cache

Planned / In Progress:

* Support for field collections
* Term create / delete / cleanup
* Support Image Reference / Upload

Not Yet Supported:

* Run Cron
* Create new user role and assign to newly created users / delete role when finished
* Assign specific permissions to newly created user roles (with built in blacklist for added security).
* Batch process
* Support for Drupal 6
* Support for Drupal 8

Contributors:

* Alfred Nutile
* Nathan Kirschbaum
