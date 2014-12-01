#!/bin/bash

composer install

export PATH=$PATH:./application/vendor/bin

phpmd ./application/module xml cleancode,codesize,controversial,design,naming,unusedcode --reportfile ./build/logs/phpmd.xml

/usr/bin/php phpcpd.phar --verbose ./application/module

phploc --count-tests ./application/module

pdepend --jdepend-xml=./build/logs/jdepend.xml --jdepend-chart=./build/pdepend/dependencies.svg--overview-pyramid=./build/pdepend/overview-pyramid.svg ./application

phpdox ./build/

phpcs --extensions=php --standard=phpcs_ruleset.xml --ignore=autoload.php ./application/module

phpunit -c ./application/tests/phpunit/phpunit.xml --coverage-clover ./build/logs/clover.xml --coverage-html ./build/reports/

find ./application/module/ -type f -name \*.php -exec php -l {} \;

behat --config ./tests/behat/behat.yml