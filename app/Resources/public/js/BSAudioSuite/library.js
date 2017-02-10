'use strict';
import jQuery from 'jquery';

export default class Library {

  static watchSongs(player)
  {

    jQuery("main").on('click', '[data-song]', (e) => {
      player.addToQueue(jQuery(this));
      player.autoStart();
    });

    jQuery("main").on('click', '.btn-play-album', function ()
    {
      jQuery('[data-song]').each(function ()
      {
        player.addToQueue(jQuery(this));
      });
      player.autoStart();
    });
  };
}