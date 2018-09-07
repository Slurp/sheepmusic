#!/bin/bash
set -x
if [ $TRAVIS_BRANCH == 'master' ] ; then
    git config user.name "Travis CI"
    git config user.email "slurpie+travisCI@gmail.com"

   git config --global push.default matching
   git remote add deploy ssh://git@$DEPLOY_HOST:$DEPLOY_PATH
   git push deploy master
else
    echo "Not deploying, since this branch isn't master."
fi

