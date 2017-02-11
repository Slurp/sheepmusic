'use strict';
import * as Push from 'push.js';

export default class Notification {

  static notifySong(song)
  {
    Push.close('songNotification');
    const promise = Push.create(`♫ ${song.getTitle()}`, {
      body:    `${song.getAlbum().name} – ${song.getArtistName()}`,
      icon:    `${song.getAlbum().cover}`,
      timeout: 3000,
      tag:     'songNotification'
    });

    promise.then(notification =>
    {
      notification.close();
    });
  }
}