#!/bin/sh
set -e

composer install --no-interaction
exec php-fpm
