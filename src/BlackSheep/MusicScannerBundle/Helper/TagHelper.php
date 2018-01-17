<?php

/*
 * This file is part of the BlackSheep Music.
 *
 * (c) Stephan Langeweg <slurpie@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BlackSheep\MusicScannerBundle\Helper;

use BlackSheep\MusicLibraryBundle\Model\SongAudioInfo;
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

    /**
     * Get id3tag helper.
     */
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
        $info = $this->getID3->analyze($file->getPathname());

        if (isset($info['error']) || !isset($info['playtime_seconds'])) {
            return null;
        }

        return $this->getPropsFromTags($info, $this->getDefaultArray($file, $info));
    }

    /**
     * @param $file
     * @param $info
     *
     * @return array
     */
    private function getDefaultArray(SplFileInfo $file, $info)
    {
        return [
            'artist' => '',
            'album' => '',
            'title' => '',
            'length' => $info['playtime_seconds'],
            'lyrics' => '',
            'cover' => $this->getCover($info),
            'path' => $file->getPathname(),
            'mTime' => $file->getMTime(),
            'year' => '',
            'genre' => '',
            'track' => '',
            'artist_mbid' => '',
            'album_mbid' => '',
        ];
    }

    /**
     * @param $info
     * @param $props
     *
     * @return array
     */
    private function getPropsFromTags(&$info, $props)
    {
        // Copy the available tags over to comment.
        // This is a helper from getID3, though it doesn't really work well.
        // We'll still prefer getting ID3v2 tags directly later.
        // Read on.
        getid3_lib::CopyTagsToComments($info);
        if (isset($info['comments_html'])) {
            if (isset($info['comments_html']['track'][0])) {
                $props['track'] = $info['comments_html']['track'][0];
            }
            foreach ($info['tags'] as $tagName => $value) {
                $this->getPropsForTags($info, $props, $tagName);
            }
            $this->getPropsForTags($info, $props);
            $this->handleAudioInfo($info, $props);
            unset($info);
        }

        return $props;
    }

    /**
     * @param $info
     */
    private function getCover(&$info)
    {
        $cover = null;
        if (isset($info['comments']['picture'])) {
            $cover = $info['comments']['picture'][0];
            unset($info['comments']['picture']);
        }

        return $cover;
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
            $this->getPropertyForTag($props, $tags, 'artist');
            $this->getPropertyForTag($props, $tags, 'album');
            $this->getPropertyForTag($props, $tags, 'title');
            $this->getPropertyForTag($props, $tags, 'artist_mbid', 'musicbrainz_artistid');
            $this->getPropertyForTag($props, $tags, 'album_mbid', 'musicbrainz_albumid');
            $this->getPropertyForTag($props, $tags, 'year');
            $this->getPropertyForTag($props, $tags, 'genre');
            if (isset($tags['text'])) {
                $this->getPropertyForTag($props, $tags['text'], 'artist_mbid', 'MusicBrainz Album Artist Id');
                $this->getPropertyForTag($props, $tags['text'], 'album_mbid', 'MusicBrainz Album Id');
            }
        }
    }

    /**
     * @param $props
     * @param $tags
     * @param string $propertyName
     * @param string $tagName
     */
    private function getPropertyForTag(&$props, $tags, $propertyName, $tagName = null)
    {
        if ($tagName === null) {
            $tagName = $propertyName;
        }
        if (isset($tags[$tagName]) && empty($tags[$tagName]) === false) {
            if (is_string($tags[$tagName])) {
                $props[$propertyName] = trim($tags[$tagName]);
            }
            if (is_array($tags[$tagName])) {
                $props[$propertyName] = trim($tags[$tagName][0]);
            }
        }
    }

    /**
     * @param $info
     * @param $props
     */
    private function handleAudioInfo(&$info, &$props)
    {
        if (isset($info['audio'])) {
            foreach (SongAudioInfo::getAllowedKeys() as $key) {
                if (isset($info['audio'][$key])) {
                    $props['audio'][$key] = $info['audio'][$key];
                }
            }
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
                    'option_tags_html' => true,
                    'option_extra_info' => true,
                ]
            );
        }
    }
}
