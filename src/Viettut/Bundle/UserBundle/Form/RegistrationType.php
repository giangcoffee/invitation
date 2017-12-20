<?php
/**
 * Created by PhpStorm.
 * User: giangle
 * Date: 12/1/16
 * Time: 9:01 PM
 */

namespace Viettut\Bundle\UserBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Viettut\Exception\InvalidArgumentException;
use Viettut\Model\User\UserEntityInterface;

class RegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('professional')
        ;

        $builder->addEventListener(
            FormEvents::POST_SUBMIT,
            function (FormEvent $event) {
                /** @var UserEntityInterface $user */
                $user = $event->getData();
                $form = $event->getForm();
                if (strlen($user->getUsername()) < 6) {
                    $form->get('username')->addError(new FormError('Tên đăng nhập quá ngắn, ít nhất 6 ký tự!'));
                }

                if (!preg_match('/^[A-Za-z][A-Za-z0-9_]$/', $user->getUsername())) {
                    $form->get('username')->addError(new FormError('Tên đăng nhập không bắt đầu bằng số và chỉ gồm chữ cái, số, dâu gạch chân!'));
                }

                if ($user->getId() === null) {
                    $hash = md5(trim($user->getEmail()));
                    $user->setAvatar(sprintf('http://gravatar.com/avatar/%s?size=64&d=identicon', $hash));
                }
            }
        );
    }

    public function getParent()
    {
        return 'fos_user_registration';
    }

    public function getName()
    {
        return 'viettut_user_registration';
    }
}