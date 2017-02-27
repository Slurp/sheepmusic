'use strict';
import jQuery from 'jquery';
import Album from './stores/album';
import Artist from './stores/artist';

export default class Library {

  static watchSongs(player,playlist)
  {
    jQuery("main").on('click', '[data-song]', function () {
      player.addToQueue(jQuery(this));
      playlist.renderPlaylist();
      player.autoStart();
    });

    jQuery("main").on('click', '[data-queue_album]', function ()
    {
      let album = new Album($(this).data('queue_album'));
      playlist.addAlbum(album).then(() =>
      {
        playlist.renderPlaylist();
        player.autoStart();
      });
    });
    jQuery("main").on('click', '[data-queue_artist_albums]', function ()
    {
      let artist = new Artist($(this).data('queue_artist_albums'));
      playlist.addArtist(artist).then(() =>
      {
        playlist.renderPlaylist();
        player.autoStart();
      });
    });
  };
}