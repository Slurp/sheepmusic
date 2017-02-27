'use strict';
import jQuery from 'jquery';

export default class Song {

  constructor($src, $songInfoUrl, $apiData)
  {
    this.src = $src;
    this.songInfoUrl = $songInfoUrl;
    if (typeof $apiData !== "undefined") {
      this.apiData = $apiData;
      this.src = $apiData.src;
    }
  };

  getInfo()
  {
    if (typeof this.apiData === "undefined" || this.apiData === null) {
      return jQuery.when(jQuery.get({url: this.songInfoUrl})).done((data) =>
      {
        this.src = data.src;
        this.apiData = data;
        return this;
      });
    }
    return jQuery.when().done(() =>
      {
        return this;

      }
    );
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