<?php
/**
* (c) Netvlies Internetdiensten
*
* @author Sjoerd Peters <speters@netvlies.nl>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

use Silex\Provider\WebProfilerServiceProvider;

// include the prod configuration
require __DIR__.'/prod.php';

// enable the debug mode
$app['debug'] = true;

$app['monolog.logfile'] = dirname(__DIR__) . '/../logs/dev.log';

//$app->register($p = new WebProfilerServiceProvider(), array(
//    'profiler.cache_dir' => dirname(__DIR__) . '/cache/profiler',
//));
//$app->mount('/_profiler', $p);


