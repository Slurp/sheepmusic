'use strict';
import * as Push from 'push.js';

export default class Notification {

  static notifySong(song)
  {
    Push.close('songNotification');
    const promise = Push.create(`♫ ${self.currentSong.getTitle()}`, {
      body:    `${self.currentSong.getAlbum().name} – ${self.currentSong.getArtistName()}`,
      icon:    `${self.currentSong.getAlbum().cover}`,
      timeout: 3000,
      tag:     'songNotification'
    });

    promise.then(notification =>
    {
      notification.close();
    });
  }
}