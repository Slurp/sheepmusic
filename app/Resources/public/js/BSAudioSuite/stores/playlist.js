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
              console.log('songs', song);
              let newSong = new Song('', '', song);
              this.songs.push(newSong);
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
    let active = 0;
    if(this.currentIndex > 0) {
      active = this.currentIndex;
    }
    return this.songs.reduce(function (promise, song)
    {
      return promise.then(function ()
      {
        return song.getInfo().then(() =>
          {
            let activeClass ='';
            if(active === i) {
              activeClass = 'playing'
            }
            playlistHtml.append(
              `<li class="playlist-item ${activeClass}" data-playlist-index="${i}">
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
        this.renderPlaylist();
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