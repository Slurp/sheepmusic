var BlackSheepPlayer = BlackSheepPlayer || {};

BlackSheepPlayer = (function ($, window, plyr, Push)
{

    /**
     * Functions
     */
    var init,
        watchSongs,
        watchButtons,
        watchEvents,
        notifySong,
        restart,
        setVolume,
        mute,
        unmute,
        stop,
        pause,
        resume;

    /**
     * Objects
     * @type {null}
     */
    var player       = null,
        $volumeInput = null,
        repeatModes  = ['NO_REPEAT', 'REPEAT_ALL', 'REPEAT_ONE'],
        initialized  = false,
        currentSong  = null;
    /**
     * Init the module
     */
    init = function ()
    {
        // We don't need to init this service twice, or the media events will be duplicated.
        if (initialized) {
            return;
        }
        $volumeInput = $('#volumeRange');

        var instances = plyr.setup({
            debug:      false,
            controls:   ['progress'],
            loadSprite: false
        });

        // Plyr returns an array regardless
        player = instances[0];
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

    watchSongs = function ()
    {
        $("main").on('click', '[data-song]', function ()
        {
            var $element = $(this);
            $.get($element.data('song_info')).done(function (data)
            {
                self.currentSong = data;
                $('title').text(`${self.currentSong.title} ♫ sheepMusic`);
                $('.plyr audio').attr('title', `${self.currentSong.artist.name} - ${self.currentSong.title}`);
                notifySong();
            });
            player.source({
                type:    'audio',
                title:   '-',
                sources: [{
                    src:  $element.data('song'),
                    type: 'audio/mp3'
                }]
            });

            // We'll just "restart" playing the song, which will handle notification, scrobbling etc.
            restart();
        });
    };

    watchButtons = function ()
    {

        $(".player-play").on('click', function ()
        {
            if (player.getMedia().paused === false) {
                pause();
            } else {
                resume();
            }
        });

        $(".player-mute").on('click', '.player', function ()
        {
            if (player.getMedia().muted === false) {
                mute();
            } else {
                unmute();
            }
        });
    };

    watchEvents = function ()
    {
        player.on('timeupdate', function (event)
        {
            updateSongProgress(event.detail.plyr);
        });
    };

    updateSongProgress = function (plyr)
    {
        if (typeof plyr === 'string' || plyr instanceof String) {
            $('.player .progress').val(plyr);
        } else {
            var percentage = (plyr.getCurrentTime() / plyr.getDuration()) * 100;
            $('.player .progress').val(percentage);
            $('.player #time .time-cur').text(plyr.getCurrentTime());
        }
    };

    notifySong = function ()
    {
        var promise = Push.create(`♫ ${currentSong.title}`, {
            body:    `${currentSong.album.name} – ${currentSong.artist.name}`,
            icon:    `${currentSong.album.cover}`,
            timeout: 5000
        });
        $('.player .playing-song-title').text(currentSong.artist.name + ' : ' + currentSong.title);
        $('.player .song-image').attr('src', currentSong.album.cover);
        // Somewhere later in your code...

        promise.then(function (notification)
        {
            notification.close();
        });
    };

    restart = function ()
    {
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
    setVolume = function (volume)
    {
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
    stop = function ()
    {
        player.pause();
        player.seek(0);
    };

    /**
     * Pause playback.
     */
    pause = function ()
    {
        player.pause();
    };

    /**
     * Resume playback.
     */
    resume = function ()
    {
        player.play();
    };

    return {
        init: init
    };

}(jQuery, window, plyr, Push));

$(function ()
{
    BlackSheepPlayer.init();
});