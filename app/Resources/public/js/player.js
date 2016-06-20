var BlackSheepPlayer = BlackSheepPlayer || {};

BlackSheepPlayer = (function ($, window, plyr, undefined)
{

    /**
     * Functions
     */
    var init,
        watchSongs,
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
            controls: []
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
    };

    watchSongs = function ()
    {
        $('[data-song]').on('click', function ()
        {
            var $element = $(this);
            console.log($element.data('song'));
            $('title').text(`♫ sheepMusic`);
            $('.plyr audio').attr('title', $element.data('song'));
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

    restart = function ()
    {
        player.restart();
        player.play();

        // Show the notification if we're allowed to
        if (!window.Notification) {
            return;
        }

        try {
            const notification = new Notification(`♫ ${song.title}`, {
                icon: song.album.cover,
                body: `${song.album.name} – ${song.artist.name}`
            });

            notification.onclick = () => window.focus();

            // Close the notif after 5 secs.
            window.setTimeout(() => notification.close(), 5000);
        } catch (e) {
            // Notification fails.
            // @link https://developer.mozilla.org/en-US/docs/Web/API/ServiceWorkerRegistration/showNotification
        }
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
        this.player.pause();
    };

    /**
     * Resume playback.
     */
    resume = function ()
    {
        this.player.play();
    };

    return {
        init: init
    };

}(jQuery, window, plyr));

$(function ()
{
    BlackSheepPlayer.init();
});