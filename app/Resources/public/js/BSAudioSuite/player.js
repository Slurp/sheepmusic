import jQuery from 'jquery';
import plyr from 'plyr';
import Notifications from './services/notifications';
import BlackSheepPlaylist from './stores/playlist';
import BlackSheepLibrary from './library';
import Waveform from '../vendor/waveform';

export default class BlackSheepPlayer {

  constructor(){
    this.initialized = false;
    this.player = null;
    this.repeatModes = ['NO_REPEAT', 'REPEAT_ALL', 'REPEAT_ONE'];

    this.currentSong = null;
    this.playlist = null;
    this.init();
    this.$volumeInput = null;
  }


  /**
   * Init the module
   */
  init()
  {
    // We don't need to init this service twice, or the media events will be duplicated.
    if (this.initialized) {
      return;
    }

    let controls = [].join("");

    this.player = plyr.setup(
      {
        html:       controls,
        loadSprite: false,
        debug: false
      }
    )[0];

    this.playlist = new BlackSheepPlaylist();
    this.playlist.watchSongs(this);
    BlackSheepLibrary.watchSongs(this,this.playlist);
    this.watchButtons();
    this.watchEvents();
  };

  updateAudioElement(src)
  {
    this.player.source({
      type:    'audio',
      title:   '-',
      sources: [{
        src:  src,
        type: 'audio/mp3'
      }]
    });
  };


  playSong(song)
  {
    this.currentSong = song;
    this.updateAudioElement(this.currentSong.getSrc());
    $('title').text(`${this.currentSong.getTitle()} ♫ sheepMusic`);
    $('.plyr audio').attr('title', `${this.currentSong.getArtistName()} - ${this.currentSong.getTitle()}`);
    $('.player .playing-song-title').text(`${this.currentSong.getArtistName()} : ${this.currentSong.getTitle()}`);
    $('.player .song-image').attr('src', this.currentSong.getAlbum().cover);
    Notifications.notifySong(song);
    this.restart();
  };

  addToQueue($element)
  {
    this.playlist.addSong($element.data('song'), $element.data('song_info'));
  };

  autoStart()
  {
    if (this.player.getMedia().paused !== false) {
      this.playNext();
    }
  };

  playNext()
  {
    jQuery.when(this.playlist.getNextSong()).then((song) =>
      {
        this.playSong(song);
      }
    );
  };

  restart()
  {
    this.player.restart(0);
    this.player.play();
  };

  watchButtons()
  {
    jQuery("[data-plyr='next']").on('click', () =>
    {
      this.playNext();
    });

    jQuery("[data-plyr='previous']").on('click', () =>
    {
      jQuery.when(this.playlist.getPrevSong()).then((song) =>
        {
          this.playSong(song);
        }
      )
    });

  };

  watchEvents()
  {
    /**
     * Listen to 'ended' event on the audio player and play the next song in the queue.
     */
    document.querySelector('.plyr').addEventListener('ended', () =>
    {
      this.playNext();
    });
  };
}

jQuery(() =>
{
   new BlackSheepPlayer();
});