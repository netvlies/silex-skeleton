<?php

/**
 * (c) Netvlies Internetdiensten
 *
 * @author Sjoerd Peters <speters@netvlies.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

require_once __DIR__.'/../vendor/autoload.php';

$app = new Silex\Application();

if (isset($_SERVER['SERVER_ADDR']) && $_SERVER['SERVER_ADDR'] == '33.33.33.10') {
    require __DIR__.'/../resources/config/dev.php';
    die('here');
} else {
    die('there');
    require __DIR__.'/../resources/config/prod.php';
}

require __DIR__.'/../src/app.php';

require __DIR__.'/../src/listeners.php';
require __DIR__.'/../src/controllers.php';


if(!$app['debug']){
    $app['http_cache']->run();
} else {
    $app->run();
}
