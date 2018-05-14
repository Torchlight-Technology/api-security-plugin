# ApiGateway plugin for CakePHP

## Installation

You can install this plugin into your CakePHP application using [composer](http://getcomposer.org).

The recommended way to install composer packages is:

```
composer require torchlighttechnology/api-security-plugin
```


## Configuration

Load the plugin in the host app's config/bootstrap.php file:
```
Plugin::load('ApiGateway', ['bootstrap' => true, 'routes' => true]);
```


Add the AwsAuthenticator Component in src/Controller/AppController.php:
```
public function initialize()
{
        parent::initialize();

        $this->loadComponent('ApiGateway.AwsAuthenticator');
}
```

Run the plugins migrations:
```
bin/cake migrations migrate -p ApiGateway
```

