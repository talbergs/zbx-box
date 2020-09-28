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

cd /tmp/var/www/html
chmod 777 -R /tmp/var/www/html
mv conf/api-json-zabbix.conf.php conf/zabbix.conf.php

sed -i ./tests/include/web/CPage.php -re 's/(new ChromeOptions\\(\\);)$/\\1\\n\\t\\t\\t$options->setExperimentalOption("w3c", false);/'


php -S 0.0.0.0:8020 2>/dev/null &
sleep 2
cd tests

cp -r /test/vendor /tmp/var/www/html/tests

/tmp/var/www/html/tests/vendor/bin/phpunit --bootstrap bootstrap.php $@

echo "DONE waiting for ctrl-c .."
while true ; do
    sleep 1
done
