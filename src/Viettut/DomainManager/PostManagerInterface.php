<?php
/**
 * Created by PhpStorm.
 * User: giang
 * Date: 10/21/15
 * Time: 10:07 PM
 */

namespace Viettut\DomainManager;



use Viettut\Model\Core\PostInterface;

interface PostManagerInterface extends ManagerInterface
{
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