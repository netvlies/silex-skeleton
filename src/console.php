<?php
/**
* (c) Netvlies Internetdiensten
*
* @author Sjoerd Peters <speters@netvlies.nl>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

use Doctrine\DBAL\DriverManager;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;

$console = new Application('Netvlies Silex Skeleton', '0.1');

$app->boot();

if (isset($app['cache.path'])) {
    $console
        ->register('cache:clear')
        ->setDescription('Clears the cache')
        ->setCode(function (InputInterface $input, OutputInterface $output) use ($app) {

            $cacheDir = $app['cache.path'];
            $finder = Finder::create()->in($cacheDir)->notName('.gitkeep');

            $filesystem = new Filesystem();
            $filesystem->remove($finder);

            $output->writeln(sprintf("%s <info>success</info>", 'cache:clear'));
    });
}

$console
    ->register('doctrine:schema:show')
    ->setDescription('Output schema declaration')
    ->setCode(function (InputInterface $input, OutputInterface $output) use ($app) {
        $schema = require __DIR__.'/../resources/db/schema.php';

        foreach ($schema->toSql($app['db']->getDatabasePlatform()) as $sql) {
            $output->writeln($sql.';');
        }
    })
;

$console
    ->register('doctrine:schema:load')
    ->setDescription('Load schema')
    ->setCode(function (InputInterface $input, OutputInterface $output) use ($app) {
        $schema = require __DIR__.'/../resources/db/schema.php';

        foreach ($schema->toSql($app['db']->getDatabasePlatform()) as $sql) {
            $app['db']->exec($sql.';');
        }
    })
;

$console
    ->register('doctrine:fixtures:load')
    ->setDescription('Load fixtures')
    ->setCode(function (InputInterface $input, OutputInterface $output) use ($app) {

        $articles = array(
            array(
                'title' => 'Wat is de basis?',
                'created' => '2014-02-02 18:30:45',
                'content' => 'Lid est laborum dolo rumes fugats untras. Etharums ser quidem rerum facilis dolores nemis
                omnis fugats vitaes nemo minima rerums unsers sadips amets. Sed ut perspiciatis unde omnis iste natus
                error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo
                inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.',
                'img' => 'slide-1.jpg'
            ),
            array(
                'title' => 'Referentie materiaal',
                'created' => '2014-02-01 13:10:05',
                'content' => 'Lid est laborum dolo rumes fugats untras. Etharums ser quidem rerum facilis dolores nemis
                omnis fugats vitaes nemo minima rerums unsers sadips amets. Sed ut perspiciatis unde omnis iste natus
                error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo
                inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.',
                'img' => 'slide-2.jpg'
            ),
            array(
                'title' => 'Waarom een zandbak?',
                'created' => '2014-01-31 09:41:23',
                'content' => 'Lid est laborum dolo rumes fugats untras. Etharums ser quidem rerum facilis dolores nemis
                omnis fugats vitaes nemo minima rerums unsers sadips amets. Sed ut perspiciatis unde omnis iste natus
                error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo
                inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.',
                'img' => 'slide-3.jpg'
            ),
        );

        foreach ($articles as $article) {
            $output->writeln(sprintf('<info>Inserting Article - <comment>%s</comment></info>', $article['title']));
            $app['db']->insert('article', $article);
        }
    })
;

$console
    ->register('doctrine:database:drop')
    ->setName('doctrine:database:drop')
    ->setDescription('Drops the configured databases')
    ->addOption('connection', null, InputOption::VALUE_OPTIONAL, 'The connection to use for this command')
    ->addOption('force', null, InputOption::VALUE_NONE, 'Set this parameter to execute this action')
    ->setHelp(<<<EOT
The <info>doctrine:database:drop</info> command drops the default connections
database:

<info>php app/console doctrine:database:drop</info>

The --force parameter has to be used to actually drop the database.

You can also optionally specify the name of a connection to drop the database
for:

<info>php app/console doctrine:database:drop --connection=default</info>

<Error>Be careful: All data in a given database will be lost when executing
this command.</Error>
EOT
        )
        ->setCode(function (InputInterface $input, OutputInterface $output) use ($app) {
        $connection = $app['db'];

        $params = $connection->getParams();

        $name = isset($params['path']) ? $params['path'] : (isset($params['dbname']) ? $params['dbname'] : false);

        if (!$name) {
            throw new \InvalidArgumentException("Connection does not contain a 'path' or 'dbname' parameter and cannot be dropped.");
        }

        if ($input->getOption('force')) {
            // Only quote if we don't have a path
            if (!isset($params['path'])) {
                $name = $connection->getDatabasePlatform()->quoteSingleIdentifier($name);
            }

            try {
                $connection->getSchemaManager()->dropDatabase($name);
                $output->writeln(sprintf('<info>Dropped database for connection named <comment>%s</comment></info>', $name));
            } catch (\Exception $e) {
                $output->writeln(sprintf('<Error>Could not drop database for connection named <comment>%s</comment></Error>', $name));
                $output->writeln(sprintf('<Error>%s</Error>', $e->getMessage()));

                return 1;
            }
        } else {
            $output->writeln('<Error>ATTENTION:</Error> This operation should not be executed in a production environment.');
            $output->writeln('');
            $output->writeln(sprintf('<info>Would drop the database named <comment>%s</comment>.</info>', $name));
            $output->writeln('Please run the operation with --force to execute');
            $output->writeln('<Error>All data will be lost!</Error>');

            return 2;
        }
    })
;
$console
    ->register('doctrine:database:create')
    ->setDescription('Creates the configured databases')
    ->addOption('connection', null, InputOption::VALUE_OPTIONAL, 'The connection to use for this command')
    ->setHelp(<<<EOT
The <info>doctrine:database:create</info> command creates the default
connections database:

<info>php app/console doctrine:database:create</info>

You can also optionally specify the name of a connection to create the
database for:

<info>php app/console doctrine:database:create --connection=default</info>
EOT
    )
    ->setCode(function (InputInterface $input, OutputInterface $output) use ($app) {
        $connection = $app['db'];

        $params = $connection->getParams();
        $name = isset($params['path']) ? $params['path'] : $params['dbname'];

        unset($params['dbname']);

        $tmpConnection = DriverManager::getConnection($params);

        // Only quote if we don't have a path
        if (!isset($params['path'])) {
            $name = $tmpConnection->getDatabasePlatform()->quoteSingleIdentifier($name);
        }

        $error = false;
        try {
            $tmpConnection->getSchemaManager()->createDatabase($name);
            $output->writeln(sprintf('<info>Created database for connection named <comment>%s</comment></info>', $name));
        } catch (\Exception $e) {
            $output->writeln(sprintf('<Error>Could not create database for connection named <comment>%s</comment></Error>', $name));
            $output->writeln(sprintf('<Error>%s</Error>', $e->getMessage()));
            $error = true;
        }

        $tmpConnection->close();

        return $error ? 1 : 0;
    })
;

return $console;
