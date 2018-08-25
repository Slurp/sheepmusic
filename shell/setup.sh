#!/usr/bin/env bash

# some dirs to be setup
rm -rf public/uploads
rm -rf config/jwt
mkdir -p public/uploads/_temp

# JWT
openssl genrsa -out config/jwt/private.pem -aes256 4096
openssl rsa -pubout -in config/jwt/private.pem -out config/jwt/public.pem

#Composer
composer install

#yarn
yarn install

# Standard
bin/console doc:data:drop --force
bin/console doc:data:create
bin/console doc:schema:update --force
bin/console fos:user:create admin admin@gmail.com test

#And here we go.
bin/console music:import
bin/console library:update
bin/console fos:elastica:populate --env=prod
