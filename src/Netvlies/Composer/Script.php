<?php
/**
* (c) Netvlies Internetdiensten
*
* @author Sjoerd Peters <speters@netvlies.nl>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Netvlies\Composer;

class Script
{
    public static function install()
    {
        chmod('resources/cache', 0777);
        chmod('resources/logs', 0777);
        chmod('web/assets', 0777);
        chmod('web/assets/css', 0777);
        chmod('web/assets/js', 0777);
        chmod('console', 0500);
    }
}
