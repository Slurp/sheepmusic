# BlackSheep:Music 
[![Build Status](https://travis-ci.org/Slurp/sheepmusic.svg?branch=develop)](https://travis-ci.org/Slurp/sheepmusic)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/Slurp/sheepmusic/badges/quality-score.png?b=develop)](https://scrutinizer-ci.com/g/Slurp/sheepmusic/?branch=develop)
[![Code Coverage](https://scrutinizer-ci.com/g/Slurp/sheepmusic/badges/coverage.png?b=develop)](https://scrutinizer-ci.com/g/Slurp/sheepmusic/?branch=develop)
[![Build Status](https://scrutinizer-ci.com/g/Slurp/sheepmusic/badges/build.png?b=develop)](https://scrutinizer-ci.com/g/Slurp/sheepmusic/build-status/develop)

A music library written in Php. 
Mainly to collect al lot of meta data for your music in one place.
Also to try out Vue.js look in my other repo the find the web application.


# Why another webbased library player?
 - Because i can. I think. Add a issue if you think i can't
 - There wan't a Symfony based one? Let me know if there is one.
 - The challenge to create one that can handle a big collections.
 - Collect artwork and metadata from all kinds of places. Not just lastfm.
 
Furthermore:
 - In the future there is going to be a app.
 - Use native flac files for html5 audio.
 
# Frontend
 The frontend is now removed and this is used only for the backend.
 Because Vuejs is a nice frontend framework but but also wanted other users to use this backend but create there own frontend.
 You know something about taste and stuff.

# The Black Sheep thanks:
 - Koel for the idea.
 - Bootstrap for a nice css framework.
 - Symfony for a nice php framework
 - Materialize and Bootstrap material design for the css tricks
 - Plyr.io for the audio player.
 - FanartTV for their artwork.
 - LastFm for all their info.
 - ElasticSearch for their efforts with search.
 - All other bundles that i use.


# The Black Sheep Todo list
- Settings
    - Path
    - Frontend settings
    - Import settings
- Different filesystems
- Implement something https://github.com/katspaugh/wavesurfer.js
- Importer written in C++
- Musicbrainz meta data.


#Installation

Steno version:
```
git clone git@github.com:Slurp/sheepmusic.git
cd sheepmusic
composer install
php bin/console doctrine:database:create --env=test
php bin/console doctrine:schema:create --env=test
mkdir -p var/jwt # For Symfony3+, no need of the -p option
# add encription type for safety (this is a test version)
openssl genrsa -out var/jwt/private.pem
openssl rsa -pubout -in var/jwt/private.pem -out var/jwt/public.pem
bin/console fos:user:create admin admin@gmail.com test
-
```
after that you could try bin/console music:import --env=dev -vvv but at the moment it is not yet in a nice config.
Shame on me... ;(

