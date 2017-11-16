<?php


namespace Viettut\Services;


interface FacebookServiceInterface
{
    /**
     * @param $token
     * @return mixed
     */
    public function getUserAlbums($token);

    /**
     * @param $token
     * @param $albumId
     * @return mixed
     */
    public function getAlbumPhotos($token, $albumId);

    /**
     * @return mixed
     */
    public function getLoginUrl();

    /**
     * @return mixed
     */
    public function getAlbumUrl();
}