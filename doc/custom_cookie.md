## Add A Custom Cookie
[Back to the navigation](https://github.com/kirschbaum/drupal-behat-remote-api-driver#documentation)

In some cases it may be useful to add a cookie to the request header. This is typical, but might be useful if your sites use cookies for various functionality. To set a cookie, add the "request_cookie" parameter to your behat.yml file:

```
      Kirschbaum\DrupalBehatRemoteAPIDriver\DrupalRemoteExtension:
        blackbox: ~
        api_driver: 'drupal_remote_api'
        drupal_remote_api:
          login_username: 'drupal_username'
          login_password: 'drupal_password'
          request_cookie: 'cookie_name=value'
        default_driver: 'drupal_remote_api'
```
