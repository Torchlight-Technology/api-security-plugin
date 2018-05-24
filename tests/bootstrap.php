<?php
/**
 * Test suite bootstrap for ApiGateway.
 *
 * This function is used to find the location of CakePHP whether CakePHP
 * has been installed as a dependency of the plugin, or the plugin is itself
 * installed as a dependency of an application.
 */
// $findRoot = function ($root) {
//     do {
//         $lastRoot = $root;
//         $root = dirname($root);
//         if (is_dir($root . '/vendor/cakephp/cakephp')) {
//             return $root;
//         }
//     } while ($root !== $lastRoot);

//     throw new Exception("Cannot find the root of the application, unable to run tests");
// };
// $root = $findRoot(__FILE__);
// unset($findRoot);

// chdir($root);

// if (file_exists($root . '/config/bootstrap.php')) {
//     require $root . '/config/bootstrap.php';

//     //return;
// }
// require $root . '/vendor/cakephp/cakephp/tests/bootstrap.php';

// from `config/paths.php`


/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */

use Cake\Cache\Cache;
use Cake\Chronos\Chronos;
use Cake\Chronos\Date;
use Cake\Chronos\MutableDate;
use Cake\Chronos\MutableDateTime;
use Cake\Core\Configure;
use Cake\Datasource\ConnectionManager;
use Cake\Log\Log;

if (is_file('vendor/autoload.php')) {
    require_once 'vendor/autoload.php';
} else {
    require_once dirname(__DIR__) . '/vendor/autoload.php';
}

if (!defined('DS')) {
    define('DS', DIRECTORY_SEPARATOR);
}
define('ROOT', dirname(__DIR__));
define('APP_DIR', 'test_app');

define('TMP', sys_get_temp_dir() . DS);
define('LOGS', TMP . 'logs' . DS);
define('CACHE', TMP . 'cache' . DS);
define('SESSIONS', TMP . 'sessions' . DS);

define('CAKE_CORE_INCLUDE_PATH', ROOT.DS.'vendor'.DS.'cakephp'.DS.'cakephp');
define('CORE_PATH', CAKE_CORE_INCLUDE_PATH . DS);
define('CAKE', CORE_PATH . 'src' . DS);
define('CORE_TESTS', CORE_PATH . 'tests' . DS);
define('CORE_TEST_CASES', CORE_TESTS . 'TestCase');
define('TEST_APP', ROOT . DS . 'tests' . DS . 'test_app' . DS);

// Point app constants to the test app.
define('APP', TEST_APP);
define('WWW_ROOT', TEST_APP . 'webroot' . DS);
define('CONFIG', TEST_APP . 'config' . DS);

//@codingStandardsIgnoreStart
@mkdir(LOGS);
@mkdir(SESSIONS);
@mkdir(CACHE);
@mkdir(CACHE . 'views');
@mkdir(CACHE . 'models');
//@codingStandardsIgnoreEnd

require_once CORE_PATH . 'config/bootstrap.php';

date_default_timezone_set('UTC');
mb_internal_encoding('UTF-8');

Configure::write('debug', true);
Configure::write('App', [
    'namespace' => 'ApiGateway',
    'encoding' => 'UTF-8',
    'base' => false,
    'baseUrl' => false,
    'dir' => APP_DIR,
    'webroot' => 'webroot',
    'wwwRoot' => WWW_ROOT,
    'fullBaseUrl' => 'http://localhost',
    'imageBaseUrl' => 'img/',
    'jsBaseUrl' => 'js/',
    'cssBaseUrl' => 'css/',
    'paths' => [
        'plugins' => [TEST_APP . 'Plugin' . DS],
        'templates' => [APP . 'Template' . DS],
        'locales' => [APP . 'Locale' . DS],
    ]
]);

Cache::setConfig([
    '_cake_core_' => [
        'engine' => 'File',
        'prefix' => 'cake_core_',
        'serialize' => true
    ],
    '_cake_model_' => [
        'engine' => 'File',
        'prefix' => 'cake_model_',
        'serialize' => true
    ]
]);

// Ensure default test connection is defined
if (!getenv('db_dsn')) {
    putenv('db_dsn=sqlite:///:memory:');
}

ConnectionManager::setConfig('test', ['url' => getenv('db_dsn')]);
ConnectionManager::setConfig('test_custom_i18n_datasource', ['url' => getenv('db_dsn')]);

Configure::write('Session', [
    'defaults' => 'php'
]);

Log::setConfig([
    // 'queries' => [
    //     'className' => 'Console',
    //     'stream' => 'php://stderr',
    //     'scopes' => ['queriesLog']
    // ],
    'debug' => [
        'engine' => 'Cake\Log\Engine\FileLog',
        'levels' => ['notice', 'info', 'debug'],
        'file' => 'debug',
    ],
    'error' => [
        'engine' => 'Cake\Log\Engine\FileLog',
        'levels' => ['warning', 'error', 'critical', 'alert', 'emergency'],
        'file' => 'error',
    ]
]);

Chronos::setTestNow(Chronos::now());
MutableDateTime::setTestNow(MutableDateTime::now());
Date::setTestNow(Date::now());
MutableDate::setTestNow(MutableDate::now());

ini_set('intl.default_locale', 'en_US');
ini_set('session.gc_divisor', '1');

loadPHPUnitAliases();

// Fixate sessionid early on, as php7.2+
// does not allow the sessionid to be set after stdout
// has been written to.
session_id('cli');


//require 'vendor' . DS . 'autoload.php';

// if (!defined('DS')) {
//     define('DS', DIRECTORY_SEPARATOR);
// }
// define('ROOT', dirname(__DIR__));
// define('CAKE_CORE_INCLUDE_PATH', ROOT . DS . 'vendor' . DS . 'cakephp' . DS . 'cakephp');
// define('CORE_PATH', ROOT . DS . 'vendor' . DS . 'cakephp' . DS . 'cakephp' . DS);
// define('CAKE', CORE_PATH . 'src' . DS);
// define('TESTS', ROOT . DS . 'tests');
// define('APP', ROOT . DS . 'tests' . DS . 'test_app' . DS);
// define('APP_DIR', 'test_app');
// define('WEBROOT_DIR', 'webroot');
// define('WWW_ROOT', APP . 'webroot' . DS);
// define('TMP', sys_get_temp_dir() . DS);
// define('CONFIG', APP . 'config' . DS);
// define('CACHE', TMP);
// define('LOGS', TMP);

// // from `config/app.default.php` and `config/bootstrap.php`

// use Cake\Cache\Cache;
// use Cake\Console\ConsoleErrorHandler;
// use Cake\Core\App;
// use Cake\Core\Configure;
// use Cake\Core\Configure\Engine\PhpConfig;
 use Cake\Core\Plugin;
// use Cake\Database\Type;
// use Cake\Datasource\ConnectionManager;
// use Cake\Error\ErrorHandler;
// use Cake\Log\Log;
// use Cake\Mailer\Email;
// use Cake\Network\Request;
// use Cake\Routing\DispatcherFactory;
// use Cake\Utility\Inflector;
// use Cake\Utility\Security;

// $loader = new \Cake\Core\ClassLoader;
// $loader->register();
// $loader->addNamespace('TestApp', APP);

// require CORE_PATH . 'config' . DS . 'bootstrap.php';

// $config = [
//     'debug' => true,

//     'App' => [
//         'namespace' => 'App',
//         'encoding' => env('APP_ENCODING', 'UTF-8'),
//         'defaultLocale' => env('APP_DEFAULT_LOCALE', 'en_US'),
//         'base' => false,
//         'dir' => 'src',
//         'webroot' => 'webroot',
//         'wwwRoot' => WWW_ROOT,
//         'fullBaseUrl' => false,
//         'imageBaseUrl' => 'img/',
//         'cssBaseUrl' => 'css/',
//         'jsBaseUrl' => 'js/',
//         'paths' => [
//             'plugins' => [ROOT . DS . 'plugins' . DS],
//             'templates' => [APP . 'Template' . DS],
//             'locales' => [APP . 'Locale' . DS],
//         ],
//     ],

//     'Asset' => [
//         // 'timestamp' => true,
//     ],

//     'Security' => [
//         'salt' => env('SECURITY_SALT', '__SALT__'),
//     ],

//     'Cache' => [
//         'default' => [
//             'className' => 'File',
//             'path' => CACHE,
//             'url' => env('CACHE_DEFAULT_URL', null),
//         ],

//         '_cake_core_' => [
//             'className' => 'File',
//             'prefix' => 'myapp_cake_core_',
//             'path' => CACHE . 'persistent/',
//             'serialize' => true,
//             'duration' => '+2 minutes',
//             'url' => env('CACHE_CAKECORE_URL', null),
//         ],

//         '_cake_model_' => [
//             'className' => 'File',
//             'prefix' => 'myapp_cake_model_',
//             'path' => CACHE . 'models/',
//             'serialize' => true,
//             'duration' => '+2 minutes',
//             'url' => env('CACHE_CAKEMODEL_URL', null),
//         ],
//         '_cake_routes_' => [
//             'className' => 'File',
//             'prefix' => 'myapp_cake_routes_',
//             'path' => CACHE,
//             'serialize' => true,
//             'duration' => '+1 years',
//             'url' => env('CACHE_CAKEROUTES_URL', null),
//         ],
//     ],

//     'Error' => [
//         'errorLevel' => E_ALL & ~E_DEPRECATED,
//         'exceptionRenderer' => 'Cake\Error\ExceptionRenderer',
//         'skipLog' => [],
//         'log' => true,
//         'trace' => true,
//     ],

//     'Datasources' => [
//         'test' => [
//             'className' => 'Cake\Database\Connection',
//             'driver' => 'Cake\Database\Driver\Mysql',
//             'persistent' => false,
//             'host' => 'localhost',
//             //'port' => 'non_standard_port_number',
//             'username' => 'apigateway',
//             'password' => 'apigateway',
//             'database' => 'test_apigateway',
//             'encoding' => 'utf8',
//             'timezone' => 'UTC',
//             'cacheMetadata' => true,
//             'quoteIdentifiers' => false,
//             'log' => false,
//             //'init' => ['SET GLOBAL innodb_stats_on_metadata = 0'],
//             //'url' => env('DATABASE_TEST_URL', null),
//         ],
//     ],

//     'Log' => [
//         'debug' => [
//             'className' => 'Cake\Log\Engine\FileLog',
//             'path' => LOGS,
//             'file' => 'debug',
//             'levels' => ['notice', 'info', 'debug'],
//             'url' => env('LOG_DEBUG_URL', null),
//         ],
//         'error' => [
//             'className' => 'Cake\Log\Engine\FileLog',
//             'path' => LOGS,
//             'file' => 'error',
//             'levels' => ['warning', 'error', 'critical', 'alert', 'emergency'],
//             'url' => env('LOG_ERROR_URL', null),
//         ],
//     ],

//     'Session' => [
//         'defaults' => 'php',
//     ],
// ];
// Configure::write($config);

// date_default_timezone_set('UTC');
// mb_internal_encoding(Configure::read('App.encoding'));
// ini_set('intl.default_locale', Configure::read('App.defaultLocale'));

// Cache::setConfig(Configure::consume('Cache'));
// ConnectionManager::setConfig(Configure::consume('Datasources'));
// Log::setConfig(Configure::consume('Log'));
// Security::setSalt(Configure::consume('Security.salt'));

// DispatcherFactory::add('Asset');
// DispatcherFactory::add('Routing');
// DispatcherFactory::add('ControllerFactory');

// Type::build('time')
//     ->useImmutable()
//     ->useLocaleParser();
// Type::build('date')
//     ->useImmutable()
//     ->useLocaleParser();
// Type::build('datetime')
//     ->useImmutable()
//     ->useLocaleParser();


// // finally load/register the plugin using a custom path

Plugin::load('ApiGateway', ['bootstrap' => true, 'routes' => true, 'path' => ROOT]);