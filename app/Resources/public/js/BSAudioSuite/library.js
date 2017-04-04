'use strict';
import jQuery from 'jquery';
import Album from './stores/album';
import Artist from './stores/artist';
import HtmlPlaylist from './components/playlist';
import Toaster from './components/toast';

export default class Library {

  static watchEvents(player,playlist)
  {
    let toast = new Toaster;
    jQuery("main").on('click', '[data-queue_song]', function () {
      playlist.addSong($(this).data('queue_song')).then(() =>
      {
        Library.handleQueded('Added song to queue',player,playlist,toast)
      });
    });
    jQuery("main").on('click', '[data-play_song]', function () {
      playlist.clearPlaylist();
      playlist.addSong($(this).data('play_song')).then(() =>
      {
        Library.handlePlay('Play song',player,playlist,toast)
      });
    });

    jQuery("main").on('click', '[data-queue_album]', function ()
    {
      let album = new Album($(this).data('queue_album'));
      playlist.addAlbum(album).then(() =>
      {
        Library.handleQueded('Added album',player,playlist,toast)
      });
    });

    jQuery("main").on('click', '[data-queue_artist_albums]', function ()
    {
      let artist = new Artist($(this).data('queue_artist_albums'));
      playlist.addArtist(artist).then(() =>
      {
        Library.handleQueded('Added all albums',player,playlist,toast)
      });
    });
  };

  //Handle update of playlist
  static handleQueded(message,player,playlist,toast)
  {
    toast.toast(message);
    HtmlPlaylist.renderPlaylist(playlist.songs);
    player.autoStart();
  }

  static handlePlay(message,player,playlist,toast)
  {
     Library.handleQueded(message,player,playlist,toast);
  }
}