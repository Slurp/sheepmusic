'use strict';
import jQuery from 'jquery';

export default class Song {

    constructor($src, $songInfoUrl)
    {
        this.src = $src;
        jQuery.get({url:$songInfoUrl}).success(function(data) {
            this.apiData = data;
            this.src    = $src;
            console.log(this.apiData.title);
        });
    };

    getSrc()
    {
        return this.src;
    }

    getTitle()
    {
        return this.apiData.title;
    }

    getArtistName()
    {
        return this.apiData.artist.name;
    }
}