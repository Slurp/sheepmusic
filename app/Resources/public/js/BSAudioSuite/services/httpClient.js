'use strict';


export default class httpClient {

  constructor($url)
  {
    this.apiData = null;
    this.url = $url;
    this.getInfo(this.url);
  }

  getInfo($url) {
    if (typeof this.apiData === "undefined" || this.apiData === null) {
      return jQuery.when(jQuery.get({url: $url})).done((data) =>
        {
          this.apiData = data;
          return this.apiData;
        }
      );
    } else {
      return new Promise.resolve(this.apiData);
    }
  }
}
