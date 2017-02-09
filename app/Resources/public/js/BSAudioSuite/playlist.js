'use strict';

import BlackSheepSong from './stores/song';
import jQuery from 'jquery';

export default class playlist {

  constructor()
  {
    this.songs = [];
    this.currentIndex = -1;
    this.currentSong = null;
  }

  getCurrentSong()
  {
    this.currentSong = this.songs[this.currentIndex];
    let $song = this.currentSong;
    if(typeof $song !== "undefined") {
      return jQuery.when(this.currentSong.getInfo()).then(
        function returnSong()
        {
          console.log('getCurrentSong',$song);
          return $song;
        }
      );
    }
  };

  getPrevSong()
  {
    if(this.currentIndex == 0) {
      this.currentIndex = this.songs.length;
    }
    this.currentIndex--;
    return jQuery.when(this.getCurrentSong()).then(function (song)
      {
        console.log("getNext"+song);
        return song;
      }
    );
  };

  getNextSong()
  {
    this.currentIndex++;
    if(this.currentIndex >= this.songs.length) {
      this.currentIndex = 0;
    }
    return jQuery.when(this.getCurrentSong()).then(function (song)
      {
        console.log("getNext"+song);
        return song;
      }
    );
  };

  addSong($src, $apiUrl)
  {
    let song = new BlackSheepSong($src, $apiUrl);
    this.songs.push(song);
  };
}