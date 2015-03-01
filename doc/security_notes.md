## Security Notes
[Back to the navigation](https://github.com/kirschbaum/drupal-behat-remote-api-driver#documentation)

It's definitely a good idea to be careful anytime you are storing or transmiting sensitive information, especially login credentials.

Here are some things you should consider:

* Use an SSL connection on both the driver and the client sites (as passwords and other data are transmitted)
* Use basic Auth where possible
* Use firewalls where appropriate to limit access to critical functions of the Drupal site (e.g. creating or deleting users, etc).
* Limit or prevent use of the tool on production websites (e.g. only perform destructive tests on staging or pre-production environments, disabling the client module on production).
* If you plan to store credentials, be sure to encrypt them.
* Create a user role blacklist (preventing certain roles from being assigned by the tool).
