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
            debug:      true,
            controls:   [],
            loadSprite: false,
            selectors:  {
                html5:       'audio',
                embed:       '[data-type]',
                container:   '.plyr',
                controls:    {
                    container: null,
                    wrapper:   '.plyr__controls'
                },
                labels:      '[data-plyr]',
                buttons:     {
                    seek:       '[data-player="seek"]',
                    play:       '[data-player="play"]',
                    pause:      '[data-player="pause"]',
                    restart:    '[data-player="restart"]',
                    rewind:     '[data-player="rewind"]',
                    forward:    '[data-player="fast-forward"]',
                    mute:       '[data-player="mute"]',
                    captions:   '[data-player="captions"]',
                    fullscreen: '[data-player="fullscreen"]'
                },
                volume:      {
                    input:   '[data-plyr="volume"]',
                    display: '.plyr__volume--display'
                },
                progress:    {
                    container: '.progress-wrapper',
                    buffer:    '.plyr__progress--buffer',
                    played:    '.progress-wrapper .progress'
                },
                captions:    '.plyr__captions',
                currentTime: '.time-curr',
                duration:    '.plyr__time--duration'
            },
            classes:    {
                videoWrapper: 'plyr__video-wrapper',
                embedWrapper: 'plyr__video-embed',
                type:         'plyr--{0}',
                stopped:      'plyr--stopped',
                playing:      'plyr--playing',
                muted:        'plyr--muted',
                loading:      'plyr--loading',
                hover:        'plyr--hover',
                tooltip:      'plyr__tooltip',
                hidden:       'plyr__sr-only',
                hideControls: 'plyr--hide-controls',
                isIos:        'plyr--is-ios',
                isTouch:      'plyr--is-touch',
                captions:     {
                    enabled: 'plyr--captions-enabled',
                    active:  'plyr--captions-active'
                },
                fullscreen:   {
                    enabled: 'plyr--fullscreen-enabled',
                    active:  'plyr--fullscreen-active'
                },
                tabFocus:     'tab-focus'
            }
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
        $("main").on('click','[data-song]', function ()
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

        $(".player-play").on('click', function ()
        {
            if (player.media.paused === false) {
                pause();
            } else {
                resume();
            }
        });

        $(".player-mute").on('click', '.player', function ()
        {
            if (player.media.muted === false) {
                mute();
            } else {
                unmute();
            }
        });
    };

    notifySong = function ()
    {
        var promise = Push.create(`♫ ${currentSong.title}`, {
            body:    `${currentSong.album.name} – ${currentSong.artist.name}`,
            icon:    `${currentSong.album.cover}`,
            timeout: 5000
        });

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