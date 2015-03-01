
## Drupal Remote API Driver

[![Build Status](https://travis-ci.org/kirschbaum/drupal-behat-remote-api-driver.svg?branch=master)](https://travis-ci.org/kirschbaum/drupal-behat-remote-api-driver)

The remote API driver extends the popular [Drupal Extention](https://github.com/jhedstrom/drupalextension) library to support running authenticated Behat tests against remote Drupal sites. Please note that there are two main components to this project:

1. **The Drupal Remote API Driver** - This extends the existing functionality of the drupalextention project and translates supported steps (e.g. create nodes, users, etc.) into appropriate REST requests to the remote Drupal site. See "currently supported features" below. This component is only required on the site where tests will be initiated.
2. **The Drupal Remote API Client** - This is a [Drupal module](https://github.com/kirschbaum/drupal-behat-remote-api-client) that leveradges the [RestWS module](https://www.drupal.org/project/restws) and adds various helper functionality that the driver needs in order to work propertly. It is only required on the remote sites that will be tested.

If you are not already familiar with Behat or the [Drupal Extention](https://github.com/jhedstrom/drupalextension) library, you might want to head on over and review the [detailed documentation](https://behat-drupal-extension.readthedocs.org). 

**Please Note:** This package requires Behat version 2 and DrupalExtention version 1.

## Documentation

* [Installation](doc/installation.md)
* [Usage Examples] (features/drupalRemoteAPI.feature)
* [Basic Auth + Drupal Auth](doc/remote_authentication.md)
* [Support for custom tabular data](doc/custom_tabular_data.md)
* [Adding custom field formatter](doc/custom_formatter.md)
* [Add a custom cookie to request headers](doc/custom_cookie.md)
* [Notes on Security](doc/security_notes.md)

If anything is unclear or you have any questions or comments, please open an issue or [contact me directly](http://www.nathankirschbaum.com/contact). While this library is functional, it's still a work in progress. Review, feedback, and contributions are welcome. 

## Features 

* Currently Supported
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
* Planned / In Progress:
 * Support for field collections
 * Term create / delete / cleanup
 * Support Image Reference / Upload
* Not Yet Supported:
 * Run Cron
 * Create new user role and assign to newly created users / delete role when finished
 * Assign specific permissions to newly created user roles (with built in blacklist for added security).
 * Batch process
 * Support for Drupal 6
 * Support for Drupal 8

Contributors:

* [Alfred Nutile](https://github.com/alnutile)
* [Nathan Kirschbaum](https://github.com/kirschbaum)
