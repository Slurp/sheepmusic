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
        toast.toast('Added song');
        HtmlPlaylist.renderPlaylist(playlist.songs);
        player.autoStart();
      });
    });

    jQuery("main").on('click', '[data-queue_album]', function ()
    {
      let album = new Album($(this).data('queue_album'));
      playlist.addAlbum(album).then(() =>
      {
        toast.toast('Added album');
        HtmlPlaylist.renderPlaylist(playlist.songs);
        player.autoStart();
      });
    });

    jQuery("main").on('click', '[data-queue_artist_albums]', function ()
    {
      let artist = new Artist($(this).data('queue_artist_albums'));
      playlist.addArtist(artist).then(() =>
      {
        toast.toast('Added all albums');
        HtmlPlaylist.renderPlaylist(playlist.songs);
        player.autoStart();
      });
    });
  };
}