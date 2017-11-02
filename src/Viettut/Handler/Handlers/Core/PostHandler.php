<?php
/**
 * Created by PhpStorm.
 * User: giang
 * Date: 10/21/15
 * Time: 10:48 PM
 */

namespace Viettut\Handler\Handlers\Core;


use Viettut\Handler\RoleHandlerAbstract;
use Viettut\Model\Core\PostInterface;
use Viettut\Model\ModelInterface;
use Viettut\Model\User\UserEntityInterface;

class PostHandler extends RoleHandlerAbstract
{

    /**
     * @param UserEntityInterface $role
     * @return bool
     */
    public function supportsRole(UserEntityInterface $role)
    {
        return true;
    }

    protected function processForm(ModelInterface $entity, array $parameters, $method = 'PUT')
    {
        /**
         * @var PostInterface $entity
         */
        if (null === $entity->getAuthor()) {
            $entity->setAuthor($this->getUserRole());
        }

        return parent::processForm($entity, $parameters, $method);
    }
}