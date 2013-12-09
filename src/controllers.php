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
    return $app['twig']->render('index.html.twig', array());
})
    ->bind('home');

$app->get('/about', function () use ($app) {
    return $app['twig']->render('about.html.twig', array());
})
    ->bind('about');

$app->get('/news', function () use ($app) {
    $items = array(
        array(
            'title' => 'Wat is de basis?',
            'date' => 'December 8, 2013',
            'text' => 'Lid est laborum dolo rumes fugats untras. Etharums ser quidem rerum facilis dolores nemis
                omnis fugats vitaes nemo minima rerums unsers sadips amets. Sed ut perspiciatis unde omnis iste natus
                error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo
                inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.',
            'img' => false,
            'detail_link' => 'basis',
        ),
        array(
            'title' => 'Referentie materiaal',
            'date' => 'Augustus 15, 2013',
            'text' => 'Lid est laborum dolo rumes fugats untras. Etharums ser quidem rerum facilis dolores nemis
                omnis fugats vitaes nemo minima rerums unsers sadips amets. Sed ut perspiciatis unde omnis iste natus
                error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo
                inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.',
            'img' => false,
            'detail_link' => 'referentie',
        ),
        array(
            'title' => 'Waarom een zandbak?',
            'date' => 'Juni 23, 2013',
            'text' => 'Lid est laborum dolo rumes fugats untras. Etharums ser quidem rerum facilis dolores nemis
                omnis fugats vitaes nemo minima rerums unsers sadips amets. Sed ut perspiciatis unde omnis iste natus
                error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo
                inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.',
            'img' => false,
            'detail_link' => 'zandbak',
        ),
    );
    return $app['twig']->render('news.html.twig', array('items' => $items));
})
    ->bind('news');

$app->get('/news/{slug}', function ($slug) use ($app) {
    if($slug == 'basis'){
        $items = array(
            array(
                'title' => 'Wat is de basis?',
                'date' => 'December 8, 2013',
                'text' => 'Lid est laborum dolo rumes fugats untras. Etharums ser quidem rerum facilis dolores nemis
                    omnis fugats vitaes nemo minima rerums unsers sadips amets. Sed ut perspiciatis unde omnis iste natus
                    error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo
                    inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.',
                'img' => 'slide-1.jpg',
                'detail_link' => false,
            )
        );
    } elseif($slug == 'referentie'){
        $items = array(
            array(
                'title' => 'Referentie materiaal',
                'date' => 'Augustus 15, 2013',
                'text' => 'Lid est laborum dolo rumes fugats untras. Etharums ser quidem rerum facilis dolores nemis
                    omnis fugats vitaes nemo minima rerums unsers sadips amets. Sed ut perspiciatis unde omnis iste natus
                    error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo
                    inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.',
                'img' => 'slide-2.jpg',
                'detail_link' => false,
                )
            );
    } else {
        $items = array(
            array(
                'title' => 'Waarom een zandbak?',
                'date' => 'Juni 23, 2013',
                'text' => 'Lid est laborum dolo rumes fugats untras. Etharums ser quidem rerum facilis dolores nemis
                    omnis fugats vitaes nemo minima rerums unsers sadips amets. Sed ut perspiciatis unde omnis iste natus
                    error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo
                    inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.',
                'img' => 'slide-3.jpg',
                'detail_link' => false,
            )
        );
    }
    return $app['twig']->render('news.html.twig', array('items' => $items));
})
    ->bind('news_detail');

$app->get('/contact', function () use ($app) {
    return $app['twig']->render('contact.html.twig', array());
})
    ->bind('contact');

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
