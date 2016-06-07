<?php
return new \Phalcon\Config([
    'application' => [
        'defaultModule' => 'frontend',
        'debug' => env('DEBUG_MODE', false),
        'profiler' => env('PROFILER_MODE', false),
        'siteUrl' => env('APP_HOME_URL', false),
        'baseUri' => '/admin',
        'modulesDir' => ROOT_PATH . '/app/modules/',
        #'useCachingInDebugMode' => true,
        'cache' => [
            'output' => [
                'adapter' => 'File',
                'lifetime' => '3600',
                'prefix' => 'event_',
                'cacheDir' => ROOT_PATH . '/app/var/cache/data/'
            ],
            'data' => [
                'uniqueId' => env('PROJECT_ENV_NAME', 'soscredit'),
                'adapter' => '\Phalcon\Cache\Backend\Redis',
                'lifetime' => '3600',
                'prefix' => 'api_20_',
                'index' => 10,
                'host' => '127.0.0.1',
                'port' => 6379
            ]
        ],
        'session' => [
            //'uniqueId' => env('PROJECT_ENV_NAME', 'soscredit'),
            'adapter' => 'redis',
            //'adapter' => 'files',
            'name' => 'session',
            'lifetime' => 8 * 60 * 60,
            //'cookie_lifetime' => '1440',

            'path' => [
                [
                    'host' => 'redis',
                    'port' => 6379,
                    'database' => '',
                    'prefix' => 'session_' . env('PROJECT_ENV_NAME', 'soscredit') . '::'
                ]
            ],

            /*'uniqueId' => env('PROJECT_ENV_NAME', 'soscredit'),
            'host' => 'localhost',
            'port' => 6379,
            'database' => 10,
            'auth' => 'foobared',
            'persistent' => false,
            'prefix' => 'session_'*/

            /*'adapter' => 'memcache',
            'name' => 'apsession',
            'lifetime' => '3600',
            'cookie_lifetime' => '1440',
            'host' => '127.0.0.1',
            'prefix' => 'session_'.env('PROJECT_ENV_NAME', 'soscredit')*/
        ],
        'logger' => [
            'enabled' => env('LOGGER_ENABLED', true),
            'formatter' => env('LOGGER_FORMATTER', 'lines'),
            'path' => ROOT_PATH . '/app/var/logs',
            'format' => '[%date%][%type%] %message%',
            'project' => env('PROJECT_ENV_NAME', 'soscredit')
        ],
        'acl' => [
            'adapter' => 'database',
            'db' => 'db',
            'roles' => 'core_acl_role',
            'resources' => 'core_acl_resource',
            'resourcesAccesses' => 'core_acl_resource_access',
            'accessList' => 'core_acl_access_list',
            'rolesInherits' => 'core_acl_role_inherit',
            'authModel' => '\User\Model\User',
            'authKey' => 'rememberme'
        ],
        'crypt' => [
            'key' => env('PROJECT_ENV_NAME', 'soscredit')
        ],
        'view' => [
            'compiledPath' => ROOT_PATH . '/app/var/cache/view/',
            'compiledExtension' => '.php',
            'compiledSeparator' => '_',
            'compileAlways' => env('VIEW_COMPILE_ALWAYS', false),
            'prettyprint' => env('JADE_PRETTYPRINT', false),
            'cacheModeNone' => env('JADE_CACHE_MODE_NONE', false),

            'scriptsVersion' => 53
        ]
    ],
    'metadata' => [
        //'adapter' => 'Files',
        //'metaDataDir' => ROOT_PATH . '/app/cms/var/cache/metadata/',
        'adapter' => 'memcache',
        'lifetime' => '3600',
        'prefix' => 'soscredit_',
        'host' => '127.0.0.1',
        'port' => 11211
    ],
    'annotations' => [
        'adapter' => 'Files',
        'annotationsDir' => ROOT_PATH . '/app/var/cache/annotations/',
    ],
    'modules' => [
        'user' => 1,
        'api' => 1,
        'frontend' => 1,
        'generator' => 1,
        'admin' => 1,
        'core' => 1
    ],
    'adminEmail' => explode(';', env('APP_EMAIL_ADMIN')),
    'promocodeEmail' => explode(';', env('APP_EMAIL_PROMOCODE')),
    'contactEmail' => explode(';', env('APP_EMAIL_CONTACT')),
    'emailsToNotificate' => explode(';', env('APP_EMAILS_NOTIFY'))
]);