## Installation
[Back to the navigation](https://github.com/kirschbaum/drupal-behat-remote-api-driver#documentation)


### For A New Project

We'll be using Composer. First create a new folder:

```
mkdir foo_project
```

Create a new file called "composer.json" with the following:

```
{
  "require": {
  "kirschbaum/drupal-behat-remote-api-driver": "dev-master"
  },
  "config": {
  "bin-dir": "bin/"
  }
}
```

From the command line run:

```
composer install
```

### Configuration

In the foo_project folder create a file called "behat.yml". What follows is baseline configuration. See the rest of the documentation for additional options.

```
default:
    paths:
        features: features
        bootstrap: features/bootstrap
    context:
      parameters:
        base_url: 'http://remote-site.dev'
    extensions:
      Behat\MinkExtension\Extension:
        goutte: ~
        selenium2: ~
        base_url: 'http://remote-site.dev'
      Kirschbaum\DrupalBehatRemoteAPIDriver\DrupalRemoteExtension:
        blackbox: ~
        api_driver: 'drupal_remote_api'
        drupal_remote_api:
          login_username: 'drupal_username'
          login_password: 'drupal_password'
        default_driver: 'drupal_remote_api'
```

In the foo_project directory run:

```
bin/behat --init
```

Finally, you'll need to go to edit the file foo_project/features/bootstrap/FeatureContext.php. Replace the folowing line:

```
class FeatureContext extends 
```
with:
```
class FeatureContext extends \Kirschbaum\DrupalBehatRemoteAPIDriver\DrupalRemoteContext
```

And that's it! You can view pre-defined steps by running:

```
bin/behat -di
```

### For A New Project
It may be possible to add this library to an existing project. The feasibility mostly depends on what version of behat and drupalextention you are already running. This remote API libarary currently requires Behat v2 DrupalExtention v1.

### Using The Remote Client
In order for this to work with your remote Drupla site, you'll need to install and configure the [Behat Drupal Remote API Client](https://github.com/kirschbaum/drupal-behat-remote-api-client). Instructions coming soon.
