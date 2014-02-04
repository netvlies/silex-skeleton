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
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Controller Actions
 */
$app->get('/', function () use ($app) {
    return $app['twig']->render('index.html.twig', array());
})->bind('home');

$app->get('/about', function () use ($app) {
    return $app['twig']->render('pages/about.html.twig', array());
})->bind('about');

$app->get('/news', function () use ($app) {
    $articles = $app['db']->fetchAll('SELECT * FROM article');
    return $app['twig']->render('pages/news.html.twig', array('articles' => $articles));
})->bind('news');

$app->get('/news/{id}', function ($id) use ($app) {
    $sql = "SELECT * FROM article WHERE id = ?";
    $article = $app['db']->fetchAssoc($sql, array((int) $id));
    return $app['twig']->render('pages/news.html.twig', array('articles' => array($article)));
})->bind('news_detail');

$app->match('/contact', function (Request $request) use ($app) {
    /** @var Symfony\Component\Form\Form $form */
    $form = $app['form.factory']->createBuilder('form')
        ->add('name', 'text', array(
            'constraints' => array(new Assert\NotBlank(), new Assert\Length(array('min' => 5))),
            'attr' => array('class' => 'form-control')
        ))
        ->add('email', 'text', array(
            'constraints' => array(new Assert\NotBlank(), new Assert\Email()),
            'attr' => array('class' => 'form-control')
        ))
        ->add('message', 'textarea', array(
            'constraints' => array(new Assert\NotBlank(), new Assert\Length(array('min' => 5))),
            'attr' => array('class' => 'form-control', 'rows' => 6)
        ))
        ->getForm();

    $form->handleRequest($request);

    if ($form->isValid()) {
        $data = $form->getData();
        $dt = new DateTime();
        $data['created'] = $dt->format('Y-m-d H:i:s');

        $app['db']->insert('contact', $data);

        return $app['twig']->render('pages/contact.html.twig', array('submitted' => true));
    }

    return $app['twig']->render('pages/contact.html.twig', array('form' => $form->createView()));
})->bind('contact');

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
