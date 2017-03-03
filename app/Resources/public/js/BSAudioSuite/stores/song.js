'use strict';
import jQuery from 'jquery';
import HttpClient from '../services/httpClient'

export default class Song extends HttpClient {

  constructor($src, $url, $apiData)
  {
    super($url);
    this.src = $src;
    if (typeof $apiData !== "undefined") {
      this.apiData = $apiData;
      this.src = $apiData.src;
    }
  };

  played()
  {
    jQuery.post(this.apiData.events.played);
  }

  getInfo()
  {
    console.log(this.apiData);
    if (typeof this.apiData === "undefined" || this.apiData === null) {
      return jQuery.when(jQuery.get({url: this.url})).done((data) =>
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