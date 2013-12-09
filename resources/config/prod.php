<?php
/**
* (c) Netvlies Internetdiensten
*
* @author Sjoerd Peters <speters@netvlies.nl>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

// Locale
$app['locale'] = 'nl';
$app['session.default_locale'] = $app['locale'];
$app['translator.messages'] = array(
    'nl' => dirname(__DIR__) . '/resources/locales/nl.yml',
);

// Cache
$app['cache.path'] = dirname(__DIR__) . '/cache';

// Http cache
$app['http_cache.cache_dir'] = $app['cache.path'] . '/http';

// Twig cache
$app['twig.options.cache'] = $app['cache.path'] . '/twig';

// Monolog log file
$app['monolog.logfile'] = dirname(__DIR__) . '/../logs/prod.log';

// Doctrine (db)
$app['db.options'] = array(
    'driver'   => 'pdo_mysql',
    'host'     => 'localhost',
    'dbname'   => 'nvs_silex_skeleton',
    'user'     => 'root',
    'password' => 'vagrant',
);

// Swiftmailer smtp settings
$app['swiftmailer.options'] = array(
    'host'       => 'localhost',
    'port'       => '25',
    'username'   => 'username',
    'password'   => 'password',
    'encryption' => null,
    'auth_mode'  => null
);

// User
$app['security.users'] = array('username' => array('ROLE_USER', 'password'));
$app['default_email'] = 'speters@netvlies.net';

