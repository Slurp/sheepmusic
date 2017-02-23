'use strict';

import BlackSheepSong from './song';
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
    if (typeof $song !== "undefined") {
      return jQuery.when(this.currentSong.getInfo()).then(
        function returnSong()
        {
          return $song;
        }
      );
    }
  };

  getPrevSong()
  {
    if (this.currentIndex == 0) {
      this.currentIndex = this.songs.length;
    }
    this.currentIndex--;
    return jQuery.when(this.getCurrentSong()).then(function (song)
      {
        return song;
      }
    );
  };

  getNextSong()
  {
    this.currentIndex++;
    if (this.currentIndex >= this.songs.length) {
      this.currentIndex = 0;
    }
    return jQuery.when(this.getCurrentSong()).then(function (song)
      {
        return song;
      }
    );
  };

  addSong($src, $apiUrl)
  {
    let song = new BlackSheepSong($src, $apiUrl);
    this.songs.push(song);
  };

  renderPlaylist()
  {
    let playlistHtml = jQuery('[data-playlist]');
    playlistHtml.find('li').remove();
    let i = 0;
    return this.songs.reduce(function (promise, song)
    {
      return promise.then(function ()
      {
        return song.getInfo().then(() =>
          {
            playlistHtml.append(
              '<li><span>' + i + '</span>' +
              song.getArtistName() + ' - ' + song.getTitle() +
              '<a href="#" data-playlist-play="' + i + '">' +
              '<i class="material-icons">play_arrow</i>' +
              '</a>' +
              '<a href="#" data-playlist-delete="' + i + '">' +
              '<i class="material-icons">remove_from_queue</i>' +
              '</a>' +
              '</li>'
            );
            i++;
          }
        );
      });
    }, Promise.resolve());
  }

  watchSongs(player)
  {
    let $playlist = jQuery('.playlist');
    $playlist.on('click', '[data-playlist-play]', (e) =>
    {
      this.currentIndex = jQuery(e.currentTarget).data('playlist-play');
      return jQuery.when(this.getCurrentSong()).then(() =>
      {
        player.playSong(this.currentSong);
      });
    });

    $playlist.on('click', '[data-playlist-delete]', (e) =>
    {
      delete this.songs[jQuery(e.currentTarget).data('playlist-index')];
      this.songs.filter(function (a)
      {
        return typeof a !== 'undefined';
      });
      jQuery(e.currentTarget).parent().remove();
      this.renderPlaylist();
    });

  };

}