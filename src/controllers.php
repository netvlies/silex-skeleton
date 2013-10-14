<?php
/**
* (c) Netvlies Internetdiensten
*
* @author Sjoerd Peters <speters@netvlies.nl>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Controller Actions
 */
$app->get('/', function () use ($app) {
    return $app['twig']->render('index.html', array());
})
->bind('homepage');

/**
 * Error Handler
 */
$app->error(function (\Exception $e, $code) use ($app) {
    if ($app['debug']) {
        $app['monolog']->addDebug(sprintf('Caught Error: %s', $e->getMessage()));
        return;
    }
    $page = 404 == $code ? '404.html' : '500.html';
    return new Response($app['twig']->render($page, array('code' => $code)), $code);
});
