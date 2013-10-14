<?php
/**
* (c) Netvlies Internetdiensten
*
* @author Sjoerd Peters <speters@netvlies.nl>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

use Symfony\Component\HttpFoundation\Session\Storage\MockFileSessionStorage;

$app['debug'] = true;

$app['db.options'] = array(
    'driver'   => 'pdo_mysql',
    'host'     => 'localhost',
    'dbname'   => 'nvs_silex_skeleton_test',
    'user'     => 'root',
    'password' => 'vagrant',
);

$app['monolog.logfile'] = dirname(__DIR__) . '/../logs/test.log';

$app['security.users'] = array('username' => array('ROLE_USER', 'password'));

// Use FilesystemSessionStorage to store session
$app['session.storage'] = $app->share(function() {
    return new MockFileSessionStorage(sys_get_temp_dir());
});
