<?php
/**
 * Created by PhpStorm.
 * User: giang
 * Date: 26/02/2016
 * Time: 21:01
 */

namespace Viettut\Repository\Core;
use Doctrine\Common\Persistence\ObjectRepository;
use Viettut\Model\Core\PostInterface;

interface PostRepositoryInterface extends ObjectRepository
{
    /**
     * @return mixed
     */
    public function getAllPostQuery();

    /**
     * @param $hash
     * @return null|PostInterface
     */
    public function getByHash($hash);

    /**
     * @param $pageSize
     * @return mixed
     */
    public function getLatestPost($pageSize);
}