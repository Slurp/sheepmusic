'use strict';
import httpClient from '../services/httpClient';

export default class Album extends httpClient {

  constructor($url)
  {

    super($url);
  };

  getSongs()
  {
    return this.getInfo(this.url).then((e) =>
      {
        this.apiData = e;
        return this.apiData.songs;
      }
    ).catch((e) =>
    {
      console.log(e);
    });

  }

}