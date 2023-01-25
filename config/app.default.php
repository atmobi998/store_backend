<?php

use Cake\Cache\Engine\FileEngine;
use Cake\Database\Connection;
use Cake\Log\Engine\FileLog;
use Cake\Mailer\Transport\MailTransport;
use Atcmobapp\Core\Error\ExceptionRenderer;

return [

    'debug' => filter_var(env('DEBUG', false), FILTER_VALIDATE_BOOLEAN),

    'App' => [
        'namespace' => 'App',
        'encoding' => env('APP_ENCODING', 'UTF-8'),
        'defaultLocale' => env('APP_DEFAULT_LOCALE', 'en_US'),
        'defaultTimezone' => env('APP_DEFAULT_TIMEZONE', 'UTC'),
        'base' => false,
        'dir' => 'src',
        'webroot' => 'webroot',
        'wwwRoot' => WWW_ROOT,
        //'baseUrl' => env('SCRIPT_NAME'),
        'fullBaseUrl' => false,
        'imageBaseUrl' => 'img/',
        'cssBaseUrl' => 'css/',
        'jsBaseUrl' => 'js/',
        'paths' => [
            'plugins' => [ROOT . DS . 'plugins' . DS],
            'templates' => [APP . 'Template' . DS],
            'locales' => [
                APP . 'Locale' . DS,
                ROOT . DS . 'vendor' . DS . 'croogo' . DS . 'locale' . DS,
            ],
        ],
    ],

    'Security' => [
        'salt' => env('SECURITY_SALT', 'd162aecaca8ed8b34ef76d758473260315527a9df6139c810b3637968d86efc2'),
    ],

    'Asset' => [
        'timestamp' => true,
        'cacheTime' => '+1 year'
    ],

    'Cache' => [
        'default' => [
            'className' => FileEngine::class,
            'path' => CACHE,
            'url' => env('CACHE_DEFAULT_URL', null),
        ],
        '_cake_core_' => [
            'className' => FileEngine::class,
            'prefix' => 'atcmob_cake_core_',
            'path' => CACHE . 'persistent/',
            'serialize' => true,
            'duration' => '+1 years',
            'url' => env('CACHE_CAKECORE_URL', null),
        ],
        '_cake_model_' => [
            'className' => FileEngine::class,
            'prefix' => 'atcmob_cake_model_',
            'path' => CACHE . 'models/',
            'serialize' => true,
            'duration' => '+1 years',
            'url' => env('CACHE_CAKEMODEL_URL', null),
        ],
        '_cake_routes_' => [
            'className' => FileEngine::class,
            'prefix' => 'atcmob_cake_routes_',
            'path' => CACHE,
            'serialize' => true,
            'duration' => '+1 years',
            'url' => env('CACHE_CAKEROUTES_URL', null),
        ],
    ],
    
    'Error' => [
        'errorLevel' => E_ALL,
        'exceptionRenderer' => ExceptionRenderer::class,
        'skipLog' => [],
        'log' => true,
        'trace' => true,
    ],
    
    'EmailTransport' => [
        'default' => [
            'className' => MailTransport::class,
            'host' => 'mail.metroeconomics.com',
            'port' => 587,
            'timeout' => 300,
            'username' => 'admin@store.metroeconomics.com',
            'password' => 'Mcj$[%[BjCD?',
            'client' => 'smtp_helo_hostname',
            'tls'=>true,
            'url' => env('EMAIL_TRANSPORT_DEFAULT_URL', null),
        ],
    ],
    
    'Email' => [
        'default' => [
            'transport' => 'default',
            'from' => 'admin@store.metroeconomics.com',
            'charset' => 'utf-8',
            'headerCharset' => 'utf-8',
        ],
    ],
    
    'Datasources' => [
        'default' => [
            'className' => Connection::class,
            'driver' => 'Cake\Database\Driver\Mysql',
            'persistent' => false,
            'host' => 'localhost',
            'port' => '3306',
            'username' => 'metroecostore_store',
            'password' => '8tdhyCJ40hFp2yhPE5g',
            'database' => 'metroecostore_store',
            'encoding' => 'utf8mb4',
            'timezone' => 'UTC',
            'flags' => [],
            'cacheMetadata' => true,
            'log' => false,
            'quoteIdentifiers' => false,
            'init' => ['SET GLOBAL innodb_stats_on_metadata = 0'],
            'url' => env('DATABASE_URL', null),
        ],
	
        'test' => [
            'className' => Connection::class,
            'driver' => 'Cake\Database\Driver\Mysql',
            'persistent' => false,
            'host' => 'localhost',
            'port' => '3306',
            'username' => 'metroecostore_store',
            'password' => '8tdhyCJ40hFp2yhPE5g',
            'database' => 'metroecostore_store',
            'encoding' => 'utf8mb4',
            'timezone' => 'UTC',
            'flags' => [],
            'cacheMetadata' => true,
            'log' => false,
            'quoteIdentifiers' => false,
            'init' => ['SET GLOBAL innodb_stats_on_metadata = 0'],
            'url' => env('DATABASE_URL', null),
        ],
    ],
    
    'Log' => [
        'debug' => [
            'className' => FileLog::class,
            'path' => LOGS,
            'file' => 'debug',
            'url' => env('LOG_DEBUG_URL', null),
            'scopes' => false,
            'levels' => ['warning', 'error', 'critical', 'alert', 'emergency'],
        ],
        'error' => [
            'className' => FileLog::class,
            'path' => LOGS,
            'file' => 'error',
            'url' => env('LOG_ERROR_URL', null),
            'scopes' => false,
            'levels' => ['warning', 'error', 'critical', 'alert', 'emergency'],
        ],
        'queries' => [
            'className' => FileLog::class,
            'path' => LOGS,
            'file' => 'queries',
            'url' => env('LOG_QUERIES_URL', null),
            'scopes' => ['queriesLog'],
        ],
    ],
    
    'Session' => [
        'defaults' => 'php',
    ],
];
