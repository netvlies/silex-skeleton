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

// Assetic
$app['assetic.enabled']              = true;
$app['assetic.path_to_cache']        = $app['cache.path'] . '/assetic' ;
$app['assetic.path_to_web']          = dirname(__DIR__) . '/../web/assets';
$app['assetic.input.path_to_assets'] = dirname(__DIR__) . '/assets';

$app['assetic.input.path_to_css']    = $app['assetic.input.path_to_assets'] . '/css/scss/main.sass';
$app['assetic.output.path_to_css']   = 'css/styles.css';
$app['assetic.input.path_to_js']        = array(
    dirname(__DIR__) . '/../vendor/twitter/bootstrap/js/bootstrap-tooltip.js',
    dirname(__DIR__) . '/../vendor/twitter/bootstrap/js/*.js',
    $app['assetic.input.path_to_assets'] . '/js/script.js',
);
$app['assetic.output.path_to_js']    = 'js/scripts.js';

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

