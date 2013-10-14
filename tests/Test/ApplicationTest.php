<?php
/**
 * (c) Netvlies Internetdiensten
 *
 * @author Sjoerd Peters <speters@netvlies.nl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Test;

use Silex\WebTestCase;

abstract class ApplicationTest extends WebTestCase
{
    public function createApplication()
    {
        // Silex
        $app = require __DIR__ . '/../../src/app.php';
        require __DIR__ . '/../../src/listeners.php';
        require __DIR__ . '/../../src/controllers.php';
        require __DIR__ . '/../../resources/config/test.php';

        // Test mode
        unset($app['exception_handler']);

        return $app;
    }
}

