'use strict';
import httpClient from '../services/httpClient';

export default class Artist extends httpClient {

  constructor($url)
  {

    super($url);
  };

  getAlbums()
  {
    return this.getInfo(this.url).then((e) =>
      {
        console.log("getSongs",e);
        this.apiData = e;
        return this.apiData.albums;
      }
    ).catch((e) =>
    {
      console.log(e);
    });

  }

}