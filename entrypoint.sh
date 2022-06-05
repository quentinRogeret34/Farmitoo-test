#!/usr/bin/env bash
 
composer install --prefer-dist --no-progress --no-interaction
npm install --no-progress --no-audit --no-save

exec apache2-foreground