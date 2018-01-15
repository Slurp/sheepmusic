#!/usr/bin/env bash

bin/console doc:data:drop --force
bin/console doc:data:create
bin/console doc:schema:update --force
bin/console fos:user:create admin admin@gmail.com test
bin/console music:import
bin/console library:update --env=prod
bin/console fos:elastica:populate --env=prod
