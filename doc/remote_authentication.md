## Remote Authentication
[Back to the navigation](https://github.com/kirschbaum/drupal-behat-remote-api-driver#documentation)

Often times pre-production projects are hosted behind a basic auth username and password. You can provide the driver with these credentials in the behat.yml file as part of the URL. See the "base_url" setting.

```yml
default:
    paths:
        features: features
        bootstrap: features/bootstrap
    context:
      parameters:
        base_url: 'http://username:password@remote-site.dev'
    extensions:
      Behat\MinkExtension\Extension:
        goutte: ~
        selenium2: ~
        base_url: 'http://username:password@remote-site.dev'
      Kirschbaum\DrupalBehatRemoteAPIDriver\DrupalRemoteExtension:
        blackbox: ~
        api_driver: 'drupal_remote_api'
        drupal_remote_api:
          login_username: 'drupal_username'
          login_password: 'drupal_password'
        default_driver: 'drupal_remote_api'

```

As you can see in the example above, this behat.yml file is also where you would provide the necessary Drupal credentials.
