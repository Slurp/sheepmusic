#!/usr/bin/env bash

# some dirs to be setup
rm -rf config/jwt
mkdir -p config/jwt

# JWT
openssl genrsa -out config/jwt/private.pem -aes256 4096
openssl rsa -pubout -in config/jwt/private.pem -out config/jwt/public.pem

#Composer
composer install

#yarn
yarn install

# Standard
./reloaddb.sh
