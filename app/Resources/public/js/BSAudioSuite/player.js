import jQuery from 'jquery';
import plyr from 'plyr';
import Notifications from './services/notifications';
import BlackSheepPlaylist from './stores/playlist';
import BlackSheepLibrary from './library';
import HtmlPlaylist from './components/playlist';
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

    let controls = [
      "<div class='plyr__controls player-controls' id='playerControls'>",
        "<div class='row'>",
          "<button type='button' data-plyr='previous'>",
          "<i class='material-icons'>skip_previous</i>",
          "<span class='plyr__sr-only'>previous</span>",
          "</button>",
          "<button type='button' data-plyr='rewind'>",
          "<i class='material-icons'>fast_rewind</i>",
          "<span class='plyr__sr-only'>Rewind {seektime} secs</span>",
          "</button>",
          "<button type='button' data-plyr='play'>",
          "<i class='material-icons'>play_circle_outline</i>",
          "<span class='plyr__sr-only'>Play</span>",
          "</button>",
          "<button type='button' data-plyr='pause'>",
          "<i class='material-icons'>pause_circle_outline</i>",
          "<span class='plyr__sr-only'>Pause</span>",
          "</button>",
          "<button type='button' data-plyr='fast-forward'>",
          "<i class='material-icons'>fast_forward</i>",
          "<span class='plyr__sr-only'>Forward {seektime} secs</span>",
          "</button>",
          "<button type='button' data-plyr='next'>",
          "<i class='material-icons'>skip_next</i>",
          "<span class='plyr__sr-only'>next</span>",
          "</button>",
        "</div>",
      "</div>",
      "<div class='player-info'>",
        "<img src='/frontend/img/default.png' class='song-image'/>",

        "<span class='plyr__progress progress-wrapper'>",
        "<label for='seek{id}' class='plyr__sr-only'>Seek</label>",
        "<input id='seek{id}' class='plyr__progress--seek' type='range' min='0' max='100' step='0.1' value='0' data-plyr='seek'>",
        "<progress class='plyr__progress--played' max='100' value='0' role='presentation'></progress>",
        "<progress class='plyr__progress--buffer' max='100' value='0'>",
        "<span>0</span>% buffered",
        "</progress>",
        "<span class='plyr__tooltip'>00:00</span>",
        "</span>",
          "<div id='now-playing' href='#albums'>",
            "<a href='#' class='playing-song-title'>",
            "Nothing Playing",
            "</a>",
            "<span class='playing-song-meta'></span>",
            "<canvas width='453' height='66' id='showcase'></canvas>",
            "</div>",
            "<button type='button' data-plyr='restart'>",
            "<i class='material-icons'>replay</i>",
            "<span class='plyr__sr-only'>Restart</span>",
            "</button>",
          "</div>",
          "<div class='player-extra player-controls plyr__controls'>",
            "<button type='button' data-plyr='mute'>",
            "<i class='material-icons icon--muted'>volume_off</i>",
            "<i class='material-icons'>volume_mute</i>",
            "<span class='plyr__sr-only'>Toggle Mute</span>",
            "</button>",
            "<span class='plyr__volume'>",
            "<label for='volume{id}' class='plyr__sr-only'>Volume</label>",
            "<input id='volume{id}' class='plyr__volume--input' type='range' min='0' max='10' value='5' data-plyr='volume'>",
            "<progress class='plyr__volume--display' max='10' value='0' role='presentation'></progress>",
            "</span>",
            "<button class='player-repeat player-button' title='Repeat is off'>",
            "<i class='material-icons'>repeat</i>",
            "</button>",
          "</div>",
        "</div>",
      "</div>"].join("");

    this.player = plyr.setup(
      {
        html:       controls,
        loadSprite: false,
        debug: false
      }
    )[0];

    this.playlist = new BlackSheepPlaylist();
    this.playlist.watchPlaylistEvents(this);
    BlackSheepLibrary.watchEvents(this,this.playlist);
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
    HtmlPlaylist.updatePlaying(this.playlist.currentIndex);
    this.restart();
  };

  autoStart()
  {
    if (this.player.getMedia().paused !== false) {
      console.log('auto start');
      this.playNext();
    }
  };

  playNext()
  {
    jQuery.when(this.playlist.getNextSong()).then((song) =>
      {
        console.log(song);
        console.log('auto start');
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
     * Listen to 'error' event on the audio player and play the next song if any.
     */
    this.player.on('error', () => this.playNext(), true);
    /**
     * Listen to 'ended' event on the audio player and play the next song in the queue.
     */
    this.player.on('ended', e => {
      this.currentSong.played();
      //if (preferences.repeatMode === 'REPEAT_ONE') {
      //  this.restart()
      //  return
      //}
      this.playNext()
    });

    this.player.on('play', e => {
      console.log('play event');
      this.currentSong.playing();
    });


  };
}

jQuery(() =>
{
   new BlackSheepPlayer();
});