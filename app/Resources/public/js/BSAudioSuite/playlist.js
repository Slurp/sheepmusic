'use strict';

import BlackSheepSong from './stores/song';

export default class playlist {
    constructor()
    {
        this.songs       = [];
        this.currentSong = null;
    }

    getCurrentSong()
    {
        console.log(this.currentSong);
        return this.currentSong
    };

    getNextSong()
    {
        this.currentSong = this.songs[0];
        this.songs.shift();
        return this.getCurrentSong();
    };

    addSong($src, $apiUrl)
    {
        let song = new BlackSheepSong($src,$apiUrl);
        this.songs.push(song);
        if (this.songs.length === 1) {
            this.currentSong = this.songs[0];
        }
    };
}