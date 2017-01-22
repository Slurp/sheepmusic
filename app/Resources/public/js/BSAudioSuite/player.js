import jQuery from 'jquery';
import plyr from "plyr";
import * as Push from 'push.js';
import BlackSheepPlaylist from './playlist';

let BlackSheepPlayer = BlackSheepPlayer || {};

BlackSheepPlayer = ((($, window, plyr, Push) => {
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

    /**
     * Objects
     * @type {null}
     */
    let player       = null;

    let $volumeInput = null;
    const repeatModes  = ['NO_REPEAT', 'REPEAT_ALL', 'REPEAT_ONE'];
    const initialized  = false;
    const currentSong  = null;
    let playlist = null;
    /**
     * Init the module
     */
    init = () => {
        // We don't need to init this service twice, or the media events will be duplicated.
        if (initialized) {
            return;
        }
        $volumeInput = $('#volumeRange');

        const instances = plyr.setup({
            debug:      false,
            controls:   ['progress'],
            loadSprite: false
        });

        // Plyr returns an array regardless
        player = instances[0];

        playlist = new BlackSheepPlaylist();
        /**
         * Listen to 'input' event on the volume range control.
         * When user drags the volume control, this event will be triggered, and we
         * update the volume on the plyr object.
         */
        $volumeInput.on('change', function ()
        {
            setVolume($(this).val());
        });

        watchSongs();
        watchButtons();
        watchEvents();
    };


    updateAudioElement = (src) => {
        player.source({
            type:    'audio',
            title:   '-',
            sources: [{
                src:  src,
                type: 'audio/mp3'
            }]
        });
    };

    let playSong = song => {
        self.currentSong = song;
        updateAudioElement(self.currentSong.getSrc());
        $('title').text(`${self.currentSong.getTitle()} ♫ sheepMusic`);
        $('.plyr audio').attr('title', `${self.currentSong.getArtistName()} - ${self.currentSong.getTitle()}`);
        notifySong();
    };


    watchSongs = () => {
        $("main").on('click', '[data-song]', function ()
        {
            const $element = $(this);
            playlist.addSong($element.data('song'),$element.data('song_info'));
        });
    };

    watchButtons = () => {

        $(".player-play").on('click', () => {
            if (player.getMedia().paused === false) {
                pause();
            } else {
                playSong(playlist.getNextSong());
            }
        });

        $(".player-mute").on('click', '.player', () => {
            if (player.getMedia().muted === false) {
                mute();
            } else {
                unmute();
            }
        });
    };

    watchEvents = () => {
        player.on('timeupdate', event => {
            //updateSongProgress(event.detail.plyr);
        });
    };

    let updateSongProgress = plyr => {
        if (typeof plyr === 'string' || plyr instanceof String) {
            $('.player .progress').val(plyr);
        } else {
            const percentage = (plyr.getCurrentTime() / plyr.getDuration()) * 100;
            $('.player .progress').val(percentage);
            $('.player #time .time-cur').text(plyr.getCurrentTime());
        }
    };

    notifySong = () => {
        const promise = Push.create(`♫ ${self.currentSong.title}`, {
            body:    `${self.currentSong.album.name} – ${self.currentSong.artist.name}`,
            icon:    `${self.currentSong.album.cover}`,
            timeout: 5000
        });
        $('.player .playing-song-title').text(`${self.currentSong.artist.name} : ${self.currentSong.title}`);
        $('.player .song-image').attr('src', self.currentSong.album.cover);
        // Somewhere later in your code...

        promise.then(notification => {
            notification.close();
        });
    };

    restart = () => {
        player.restart(0);
        player.play();
        $('.player #time .time-total').text(player.getDuration());
    };

    /**
     * Set the volume level.
     *
     * @param {Number}         volume   0-10
     * @param {Boolean=true}   persist  Whether the volume should be saved into local storage
     */
    setVolume = volume => {
        player.setVolume(volume);
        $volumeInput.val(volume);
    };

    /**
     * Mute playback.
     */
    mute = function ()
    {
        this.setVolume(0);
    };

    /**
     * Unmute playback.
     */
    unmute = function ()
    {
        this.setVolume(7);
    };
    /**
     * Completely stop playback.
     */
    stop = () => {
        player.pause();
        player.seek(0);
    };

    /**
     * Pause playback.
     */
    pause = () => {
        player.pause();
    };

    /**
     * Resume playback.
     */
    resume = () => {
        player.play();
    };

    return {
        init
    };
})(jQuery, window, plyr, Push));

jQuery(() => {
    BlackSheepPlayer.init();
});