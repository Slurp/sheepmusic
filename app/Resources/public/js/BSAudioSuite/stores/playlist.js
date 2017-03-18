'use strict';

import Song from './song';
import Album from './album';
import Artist from './artist';
import HtmlPlaylist from '../components/playlist';
import jQuery from 'jquery';

export default class playlist {

  constructor()
  {
    this.songs = [];
    this.currentIndex = -1;
    this.currentSong = null;
    this.addEventListeners();
  }

  getCurrentSong()
  {
    this.currentSong = this.songs[this.currentIndex];
    let $song = this.currentSong;
    if (typeof $song !== "undefined") {
      return this.currentSong.getInfo().then(
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

  addSong($url)
  {
    let song = new Song('', $url);
    return jQuery.when(song.getInfo()).then(() =>
    {
      console.log('add song');
      this.songs.push(song);
    });
  };

  addAlbum(album)
  {
    if (album instanceof Album) {
      return jQuery.when(album.getSongs().then((songs) =>
        {
          console.log("addAlbum", songs);
          for (let data of songs) {
            let song = new Song('', '', data);
            this.songs.push(song);
          }
        }
      ));
    }
  }

  addArtist(artist)
  {
    if (artist instanceof Artist) {
      return jQuery.when(artist.getAlbums().then((albums) =>
        {
          console.log("addArtist", albums);
          for (let album of albums) {
            for (let song of album.songs) {
              let newSong = new Song('', '', song);
              this.songs.push(newSong);
            }
          }
        }
      ));
    }
  }



  shuffle()
  {
    for (let i = this.songs.length; i; i--) {
      let j = Math.floor(Math.random() * i);
      [this.songs[i - 1], this.songs[j]] = [this.songs[j], this.songs[i - 1]];
    }
  }

  addEventListeners()
  {
    jQuery('.player').on('click', '[data-toggle="playlist"]', (e) =>
      {
        jQuery(e.currentTarget).parent().toggleClass('show');
      }
    );
    jQuery('.player').on('click', '[data-playlist_action="shuffle"]', (e) =>
      {
        this.shuffle();
        this.currentIndex = 0;
        jQuery('[data-playlist-play="0"]').click();
        HtmlPlaylist.renderPlaylist();
      }
    );
  }

  watchPlaylistEvents(player)
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
      delete this.songs[jQuery(e.currentTarget).data('playlist-delete')];
      this.songs.filter(function (a)
      {
        return typeof a !== 'undefined';
      });
      jQuery(e.currentTarget).parent().remove();
      HtmlPlaylist.renderPlaylist();
    });

  };


}