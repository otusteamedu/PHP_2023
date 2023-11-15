#!/bin/bash

composer install --no-interaction
chmod -R 777 storage
chmod -R 777 log
php-fpm