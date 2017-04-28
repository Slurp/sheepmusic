'use strict';

export default class Playlist {

  static updatePlaying(index)
  {
    if (document.body.querySelectorAll('[data-playlist-index]').length > 0) {
      for (let element of document.body.querySelectorAll('[data-playlist-index]')) {
        element.classList.remove('playing');
      }
      document.body.querySelector('[data-playlist-index="' + index + '"]').classList.add('playing');
    }
  }

  static renderPlaylistItem(song, index, active)
  {
    let activeClass = '';
    if (active === index) {
      activeClass = 'playing'
    }
    return `<li class="playlist-item ${activeClass}" data-playlist-index="${index}">
                <img src="${song.getAlbum().cover}">
                <div class="playlist-item-info">
                  <h5 class="mt-0">${song.getTitle()}</h5>
                  <h6>${song.getArtistName()} - ${song.getAlbum().name}</h6>
                  
                </div>
                <div class="playlist-item-actions">
                <a href="#" data-playlist-play="${index}">
                       <i class="material-icons">play_arrow</i>
                   </a>
                   <a href="#" data-playlist-delete="${index}">
                    <i class="material-icons">remove_from_queue</i>
                   </a>
                </div>
              </li>`;
  }

  static renderPlaylistHeader(name)
  {
    let playlistHtml = jQuery('[data-playlistheader]');
    if (name !== null) {
      playlistHtml.text(name);
    } else {
      playlistHtml.text(playlistHtml.data('playlistheader'));
    }
  }

  static renderPlaylist(playlist)
  {
    let i = 0;
    let active = 0;
    if (this.currentIndex > 0) {
      active = this.currentIndex;
    }
    let playlistHtml = jQuery('[data-playlist]');
    playlistHtml.find('li').remove();
    Playlist.renderPlaylistHeader(playlist.name);
    return playlist.songs.reduce(function (promise, song)
    {
      return promise.then(function ()
      {
        return song.getInfo().then(() =>
          {

            playlistHtml.append(
              Playlist.renderPlaylistItem(song, i, active)
            );
            i++;
          }
        );
      });
    }, Promise.resolve());
  }
}