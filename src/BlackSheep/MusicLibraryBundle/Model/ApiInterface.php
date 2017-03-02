<?php
namespace BlackSheep\MusicLibraryBundle\Model;

/**
 * If a model has a API ?
 */
interface ApiInterface
{
    /**
     * @return array
     */
    public function getApiData();
}
