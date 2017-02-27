'use strict';

import Song from './song';
import Album from './album';
import Artist from './artist';
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
    let song = new Song($src, $apiUrl);
    this.songs.push(song);
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
          console.log("addAlbum", albums);
          for (let album of albums) {
            for (let song of album.songs) {
              this.songs.push(new Song('', '', song));
            }
          }
        }
      ));
    }
  }

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
              `<li class="playlist-item" data-playlist-index="${i}">
                <img src="${song.getAlbum().cover}">
                <div class="playlist-item-info">
                  <h5 class="mt-0">${song.getTitle()}</h5>
                  <h6>${song.getArtistName()} - ${song.getAlbum().name}</h6>
                  
                </div>
                <div class="playlist-item-actions">
                <a href="#" data-playlist-play="${ i }">
                       <i class="material-icons">play_arrow</i>
                   </a>
                   <a href="#" data-playlist-delete="${ i }">
                    <i class="material-icons">remove_from_queue</i>
                   </a>
                </div>
              </li>`
            );
            i++;
          }
        );
      });
    }, Promise.resolve());

  }

  addEventListeners()
  {
    jQuery('.player').on('click', '[data-toggle="playlist"]', (e) =>
      {
        jQuery(e.currentTarget).parent().toggleClass('show');
      }
    );
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
      delete this.songs[jQuery(e.currentTarget).data('playlist-delete')];
      this.songs.filter(function (a)
      {
        return typeof a !== 'undefined';
      });
      jQuery(e.currentTarget).parent().remove();
      this.renderPlaylist();
    });

  };

  updatePlaying()
  {
    if (document.body.querySelectorAll('[data-playlist-index]').length > 0) {
      for (let element of document.body.querySelectorAll('[data-playlist-index]')) {
        element.classList.remove('playing');
      }
      document.body.querySelector('[data-playlist-index="' + this.currentIndex + '"]').classList.add('playing');
    }
  }
}