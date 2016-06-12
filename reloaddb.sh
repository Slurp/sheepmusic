#!/usr/bin/env bash

bin/console doc:data:drop --force
bin/console doc:data:create
bin/console doc:schema:update --force
bin/console fos:user:create slurp slurpie@gmail.com warcraft3
bin/console music:import