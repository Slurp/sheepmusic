'use strict';
import jQuery from 'jquery';

export default class Song {

  constructor($src, $songInfoUrl)
  {
    this.src = $src;
    this.songInfoUrl = $songInfoUrl;
    this.apiData = null;
  };

  getInfo()
  {
    let $this = this;
    if (typeof this.apiData === "undefined" || this.apiData === null) {
      return jQuery.when(jQuery.get({url: this.songInfoUrl})).done(function (data)
      {
        $this.apiData = data;
        console.log('getInfo', $this);
        return $this;
      });
    }
    return jQuery.when().done(
      function ()
      {
        return $this;
      }
    )
  }

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

  getAlbum()
  {

    return this.apiData.album;

  }

}