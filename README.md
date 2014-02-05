# Project
    This is the Netvlies Silex Sandbox

# Getting Started

    git clone git@bitbucket.org:sjopet/silex-skeleton.git
    cd silex-skeleton
    composer.phar install

Change config parameters for the different environments by editing the config files in the resources/config directory.
Now you can setup your database by executing a few console commands.

    php console doctrine:database:create
    php console doctrine:schema:load
    php console doctrine:fixtures:load

Create a vhost and you done.

# Run the tests

    cd silex-skeleton
    phpunit
