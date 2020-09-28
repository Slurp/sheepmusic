#!/usr/bin/env bash

rm -rf public/uploads
mkdir -p public/uploads/_temp
bin/console ca:cl
bin/console ca:cl --env=prod
bin/console doc:data:drop --force
bin/console doc:data:create
bin/console doc:schema:update --force
bin/console blacksheep:user:create admin test
bin/console music:import
bin/console library:update
bin/console fos:elastica:populate --env=prod
