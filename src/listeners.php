<?php
/**
* (c) Netvlies Internetdiensten
*
* @author Sjoerd Peters <speters@netvlies.nl>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

use Symfony\Component\EventDispatcher\Event;

/**
 * Event Listeners
 */

$app['dispatcher']->addListener('mis.google.reload.users', function (Event $event) use ($app) {
    $usersData = $app['google_api']->getAllUsers();
    $users = $app['user_repo']->convert($usersData);
    $app['user_collection']->reConstruct($users);
});



