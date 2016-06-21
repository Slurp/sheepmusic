var BlackSheepPlayer = BlackSheepPlayer || {};

BlackSheepPlayer = (function ($, window, plyr, Push, undefined)
{

    /**
     * Functions
     */
    var init,
        watchSongs,
        watchButtons,
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
        initialized  = false;
    currentSong      = null;
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

        player = plyr.setup({
            controls:   [],
            loadSprite: false
        })[0].plyr;

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
    };

    watchSongs = function ()
    {
        $('[data-song]').on('click', function ()
        {
            var $element = $(this);
            console.log($element.data('song'));
            console.log($element.data('song_info'));
            $.get($element.data('song_info')).done(function (data)
            {
                console.log(data);
                self.currentSong = data;
                $('title').text(`${self.currentSong.title} ♫ sheepMusic`);
                $('.plyr audio').attr('title', `${self.currentSong.artists[0].name} - ${self.currentSong.title}`);
                notifySong();
            });

            player.source({
                type:    'audio',
                title:   'Example title',
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
        $('.player-play').on('click', '.player', function ()
        {
            if (player.playing) {
                pause();
            } else {
                resume();
            }
        });

        $('.player-play').on('click', '.player', function ()
        {

        });

        $('.player-play').on('click', '.player', function ()
        {

        });
    };

    notifySong = function ()
    {
        var promise = Push.create(`♫ ${currentSong.title}`, {
            body:    `${currentSong.album.name} – ${currentSong.artists[0].name}`,
            icon: `/uploads/${currentSong.artists[0].name}/${currentSong.album.cover}`,
            timeout: 5000
        });
     

        // Somewhere later in your code...

        promise.then(function(notification) {
            notification.close();
        });
    };

    restart = function ()
    {
        player.restart();
        player.play();
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