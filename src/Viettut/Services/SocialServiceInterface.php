<?php


namespace Viettut\Services;


interface SocialServiceInterface
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
     * @param null $targetUrl
     * @return mixed
     */
    public function getLoginUrl($targetUrl = null);

    /**
     * @param null $targetUrl
     * @return mixed
     */
    public function getZaloLoginUrl($targetUrl = null);

    /**
     * @return mixed
     */
    public function getAlbumUrl();
}