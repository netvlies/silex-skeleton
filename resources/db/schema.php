<?php
/**
* (c) Netvlies Internetdiensten
*
* @author Sjoerd Peters <speters@netvlies.nl>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

$schema = new \Doctrine\DBAL\Schema\Schema();

$post = $schema->createTable('article');
$post->addColumn('id', 'integer', array('unsigned' => true, 'autoincrement' => true));
$post->addColumn('title', 'string', array('length' => 32));
$post->addColumn('img', 'string', array('length' => 50));
$post->addColumn('content', 'text', array());
$post->addColumn('created', 'datetime', array());
$post->setPrimaryKey(array('id'));

$contact = $schema->createTable('contact');
$contact->addColumn('id', 'integer', array('unsigned' => true, 'autoincrement' => true));
$contact->addColumn('name', 'string', array('length' => 150));
$contact->addColumn('email', 'string', array('length' => 255));
$contact->addColumn('message', 'text', array());
$contact->addColumn('created', 'datetime', array());
$contact->setPrimaryKey(array('id'));

return $schema;
