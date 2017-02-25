'use strict';
import jQuery from 'jquery';

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
      jQuery('[data-song]').each(function ()
      {
        player.addToQueue(jQuery(this));
      });
      playlist.renderPlaylist();
      player.autoStart();

    });

    jQuery("main").on('click', '.btn-play-album', function ()
    {
        jQuery('[data-song]').each(function ()
        {
          player.addToQueue(jQuery(this));
        });
        playlist.renderPlaylist();
        player.autoStart();

    });
  };
}