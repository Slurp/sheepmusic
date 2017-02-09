import jQuery from 'jquery';
import plyr from 'plyr';
import * as Push from 'push.js';
import BlackSheepPlaylist from './playlist';

let BlackSheepPlayer = BlackSheepPlayer || {};

BlackSheepPlayer = ((($, window, plyr, Push) =>
{
  /**
   * Functions
   */
  let init;

  let watchSongs;
  let watchButtons;
  let watchEvents;
  let notifySong;
  let restart;
  let setVolume;
  let mute;
  let unmute;
  let stop;
  let pause;
  let resume;
  let updateAudioElement;
  let addToQueue;
  let autoStart;
  let playNext;

  /**
   * Objects
   * @type {null}
   */
  let player = null;

  let $volumeInput = null;
  const repeatModes = ['NO_REPEAT', 'REPEAT_ALL', 'REPEAT_ONE'];
  const initialized = false;
  const currentSong = null;
  let playlist = null;
  /**
   * Init the module
   */
  init = () =>
  {
    // We don't need to init this service twice, or the media events will be duplicated.
    if (initialized) {
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
        "<span class='plyr__time'>",
        "<span class='plyr__sr-only'>Current time</span>",
        "<span class='plyr__time--current'>00:00</span>",
        "</span>",
        "<span class='plyr__time'>",
        "<span class='plyr__sr-only'>Duration</span>",
        "<span class='plyr__time--duration'>00:00</span>",
        "</span>",
        "<div id='now-playing' href='#albums'>",
        "<a href='#' class='playing-song-title'>",
        "Nothing Playing",
        "</a>",
        "<span class='playing-song-meta'></span>",

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
          "<button class='player-random player-button' title='Random is On'>",
          "<i class='material-icons'>shuffle</i>",
          "</button>",
          "<!-- Right aligned menu on top of button  -->",
          "<div class='actions-wrapper actions-secondary btn-group dropup'>",
          "<button type='button'",
          "class='btn-playlist'",
          "data-toggle='dropdown'",
          "aria-haspopup='true'",
          "aria-expanded='false'>",
          "<i class='material-icons'>queue_music</i>",
          "</button>",
          "<div class='dropdown-menu dropdown-menu-right playlist'>",
          "<h3 class='playlist-header'>Current Playlist</h3>",
          "<ul>",
          "<li> no songs</li>",
          "</ul>",
          "<div class='playlist-actions'>actions</div>",
          "</div>",
          "</div>",
      "</div>"].join("");
    $volumeInput = $('#volumeRange');

    player = plyr.setup(
      {
        html: controls,
        loadSprite: false
      }
    )[0];

    playlist = new BlackSheepPlaylist();

    watchSongs();
    watchButtons();
    watchEvents();
  };

  updateAudioElement = (src) =>
  {
    player.source({
      type:    'audio',
      title:   '-',
      sources: [{
        src:  src,
        type: 'audio/mp3'
      }]
    });
  };

  let playSong = song =>
  {
    console.log(song);
    self.currentSong = song;
    updateAudioElement(self.currentSong.getSrc());
    $('title').text(`${self.currentSong.getTitle()} ♫ sheepMusic`);
    $('.plyr audio').attr('title', `${self.currentSong.getArtistName()} - ${self.currentSong.getTitle()}`);
    notifySong();
    restart();
  };

  addToQueue = ($element) =>
  {
    playlist.addSong($element.data('song'), $element.data('song_info'));
  };

  autoStart = () =>
  {
    if (player.getMedia().paused !== false) {
      playNext();
    }
  };

  playNext = () =>
  {
    $.when(playlist.getNextSong()).then(function (song)
      {
        console.log(song);
        playSong(song);
      }
    );
  };

  watchSongs = () =>
  {
    $("main").on('click', '[data-song]', function ()
    {
      addToQueue($(this));
      autoStart();
    });

    $("main").on('click', '.btn-play-album', function ()
    {
      $('[data-song]').each(function ()
      {
        addToQueue($(this));
      });
      autoStart();
    });
  };

  watchButtons = () =>
  {

    $(".player-play").on('click', () =>
    {
      if (player.getMedia().paused === false) {
        pause();
      } else {
        resume();
      }
    });

    $("[data-plyr='next']").on('click', () =>
    {
      $.when(playlist.getNextSong()).then(function (song)
        {
          console.log(song);
          playSong(song);
        }
      )
    });

    $("[data-plyr='previous']").on('click', () =>
    {
      $.when(playlist.getPrevSong()).then(function (song)
        {
          console.log(song);
          playSong(song);
        }
      )
    });

  };

  watchEvents = () =>
  {
    /**
     * Listen to 'ended' event on the audio player and play the next song in the queue.
     */
    document.querySelector('.plyr').addEventListener('ended', e =>
    {
      playNext();
    });
  };

  notifySong = () =>
  {
    Push.close('songNotification');
    const promise = Push.create(`♫ ${self.currentSong.getTitle()}`, {
      body:    `${self.currentSong.getAlbum().name} – ${self.currentSong.getArtistName()}`,
      icon:    `${self.currentSong.getAlbum().cover}`,
      timeout: 3000,
      tag:     'songNotification'
    });
    $('.player .playing-song-title').text(`${self.currentSong.getArtistName()} : ${self.currentSong.getTitle()}`);
    $('.player .song-image').attr('src', self.currentSong.getAlbum().cover);
    // Somewhere later in your code...

    promise.then(notification =>
    {
      notification.close();
    });
  };

  restart = () =>
  {
    player.restart(0);
    player.play();
  };

  /**
   * Set the volume level.
   *
   * @param {Number}         volume   0-10
   * @param {Boolean=true}   persist  Whether the volume should be saved into local storage
   */
  setVolume = volume =>
  {
    player.setVolume(volume);
  };

  /**
   * Completely stop playback.
   */
  stop = () =>
  {
    player.pause();
    player.seek(0);
  };

  return {
    init
  };
})(jQuery, window, plyr, Push));

jQuery(() =>
{
  BlackSheepPlayer.init();
});