#!/bin/bash

if [ -z $1 ];then
    echo Usage: $0 feature/ZBX-123-4.0 [phpunit args]
    exit
fi

REF=$1
shift

rm -rf /tmp/var/www/html
mkdir -p /tmp/var/www/html

cp -r /var/www/html/$REF/frontends/php/* /tmp/var/www/html 

cd /tmp/var/www/html/tests

/test/vendor/bin/phpunit --bootstrap bootstrap.php $@
