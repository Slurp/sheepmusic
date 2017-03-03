<?php
/**
 * @author    : @{USER} <stephan@bureaublauwgeel.nl>
 * Date: 17/02/16
 * Time: 00:09
 * @copyright 2016 Bureau Blauwgeel
 *
 * @version   1.0
 */

namespace BlackSheep\MusicScannerBundle\Helper;

use getID3;
use getid3_lib;
use SplFileInfo;

/**
 * Help the ID3 tag along.
 */
class TagHelper
{
    /**
     * @var getID3
     */
    protected $getID3;

    public function __construct()
    {
        $this->getGetID3();
    }

    /**
     * Get ID3 info from a file.
     *
     * @param SplFileInfo $file
     *
     * @return array|null
     */
    public function getInfo(SplFileInfo $file)
    {
        $info = null;
        $info = $this->getID3->analyze($file->getPathname());

        if (isset($info['error'])) {
            return null;
        }

        // Copy the available tags over to comment.
        // This is a helper from getID3, though it doesn't really work well.
        // We'll still prefer getting ID3v2 tags directly later.
        // Read on.
        getid3_lib::CopyTagsToComments($info);

        if (!isset($info['playtime_seconds'])) {
            return null;
        }
        $cover = null;
        if (isset($info['comments']['picture'])) {
            $cover = $info['comments']['picture'][0];
            unset($info['comments']['picture']);
        }
        $props = [
            'artist' => '',
            'album' => '',
            'title' => '',
            'length' => $info['playtime_seconds'],
            'lyrics' => '',
            'cover' => $cover,
            'path' => $file->getPathname(),
            'mTime' => $file->getMTime(),
            'track' => '',
            'artist_mbid' => '',
            'album_mbid' => '',
        ];
        if (!isset($info['comments_html']) || !$comments = $info['comments_html']) {
            return $props;
        }

        if (isset($info['comments_html']['track'][0])) {
            $props['track'] = $info['comments_html']['track'][0];
        }

        foreach ($info['tags'] as $tagName => $value) {
            $this->getPropsForTags($info, $props, $tagName);
        }
        $this->getPropsForTags($info, $props);
        unset($info);

        return $props;
    }

    /**
     * @param        $info
     * @param        $props
     * @param string $tagName
     */
    private function getPropsForTags(&$info, &$props, $tagName = 'id3v2')
    {
        if (isset($info['tags'][$tagName])) {
            $tags = $info['tags'][$tagName];
            $this->getPropertyForTag($props, $tags['artist'], 'artist', 0);
            $this->getPropertyForTag($props, $tags['album'], 'album', 0);
            $this->getPropertyForTag($props, $tags['title'], 'title', 0);
            $this->getPropertyForTag($props, $tags['title'], 'title', 0);
            $this->getPropertyForTag($props, $tags['unsynchronised_lyric'], 'unsynchronised_lyric', 0);
            $this->getPropertyForTag($props, $tags['text'], 'artist_mbid', 'MusicBrainz Album Artist Id');
            $this->getPropertyForTag($props, $tags['text'], 'album_mbid', 'MusicBrainz Album Id');
            $this->getPropertyForTag($props, $tags, 'artist_mbid', 'musicbrainz_artistid');
            $this->getPropertyForTag($props, $tags, 'album_mbid', 'musicbrainz_albumid');
        }
    }

    /**
     * @param $props
     * @param $tags
     * @param string $propertyName
     * @param $tagName
     */
    private function getPropertyForTag(&$props, $tags, $propertyName, $tagName)
    {
        if (isset($tags[$tagName]) && empty($tags[$tagName]) === false) {
            $props[$propertyName] = trim($tags[$tagName]);
        }
    }

    /**
     * Generate a unique hash for a file path.
     *
     * @param $path
     *
     * @return string
     */
    public function getHash($path)
    {
        return md5($path);
    }

    /**
     * Gets the getID3 lib.
     * can also be set by service before.
     *
     * @return getID3
     */
    public function getGetID3()
    {
        if ($this->getID3 === null) {
            $this->setGetID3();
        }

        return $this->getID3;
    }

    /**
     * @param getID3 $getID3
     */
    public function setGetID3($getID3 = null)
    {
        if ($getID3 !== null) {
            $this->getID3 = $getID3;
        } else {
            $this->getID3 = new getID3();
            // don't need this yet so don't parse.
            // waste of time and memory
            $this->getID3->setOption(
                [
                    'option_tag_lyrics3' => false,
                    'option_tag_apetag' => false,
                    'option_tags_process' => true,
                    'option_tags_html' => false,
                ]
            );
        }
    }
}
