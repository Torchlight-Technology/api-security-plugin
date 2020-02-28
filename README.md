# ApiGateway plugin for CakePHP

## Description
This CakePHP 3 plugin allows the user to specify which controller/methods are used as API endpoints through a basic UI, and enforce AWS APIGateway request parameters. For the endpoints which are specified, the plugin checks for the 'x-api-key' header in the request and verifies the value is an enabled API Key in your AWS APIGateway account. Invalid requests result in a Cake\Controller\Exception\AuthSecurityException being thrown.

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

Add the namespace into the host app's composer.json file, in the autoload-dev section:
```
"ApiGateway\\Test\\": "vendor/torchlighttechnology/api-security-plugin/tests/"
```


Add the AwsAuthenticator Component in the host app's src/Controller/AppController.php:
```
public function initialize()
{
        parent::initialize();

        $this->loadComponent('ApiGateway.AwsAuthenticator');
}
```

Run the ApiGateway migrations:
```
bin/cake migrations migrate -p ApiGateway
```

### Environment variables
ApiGateway plugin uses the AWS API to retrieve the valid AWS API Gateway keys, and it uses Redis for caching method names and API calls. The plugin relies on environment variables to make the connection to Redis and AWS.
The AWS environment variables you need to set are:
```
AWS_ACCESS_KEY_ID
AWS_SECRET_ACCESS_KEY
```
The Redis environment variables you need to set are:
```
REDIS_SERVER
```
The default value for REDIS_SERVER is localhost. If you don't want to use Redis you can use File caching by setting REDIS_ENGINE env variable to 'File' (REDIS_SERVER var will then be ignored).

## Setup
Once you have properly configured the plugin, navigate to http://yourapp.local/api-gateway/end-points. Click on 'Configure End  Points'. You should see a list of controller names with their method names as checkboxes. Select the methods that you want the plugin to protect.
There is also a Clear AWS API Cache button. This will invalidate the Redis cache, and on the next call to a protected endpoint, it will refresh with the latest API Keys from AWS APIGateway.
