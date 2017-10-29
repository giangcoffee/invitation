<?php
/**
 * Created by PhpStorm.
 * User: giang
 * Date: 10/21/15
 * Time: 10:03 PM
 */

namespace Viettut\Form\Type;


use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Viettut\Entity\Core\Card;
use Viettut\Model\Core\CardInterface;
use Viettut\Utilities\StringFactory;

class CardFormType extends AbstractRoleSpecificFormType
{
    use StringFactory;
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('template')
            ->add('data')
            ->add('gallery')
            ->add('weddingDate', DateTimeType::class, [
                'widget' => 'single_text'
            ])
        ;

        $builder->addEventListener(
            FormEvents::POST_SUBMIT,
            function(FormEvent $event) {
                /** @var CardInterface $card */
                $card = $event->getData();
                $data = $card->getData();
                if ($card->getId() == null) {
                    $name = sprintf('%s-%s-%s', $data['groom_name'], $data['bride_name'], $card->getWeddingDate()->format('Ymd'));
                    $card->setHash($this->getUrlFriendlyString($name));
                    if (empty($card->getGallery())) {
                        $card->setGallery($card->getTemplate()->getGallery());
                    }
                }
            }
        );
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver
            ->setDefaults([
                'data_class' => Card::class,
                'csrf_protection'   => false
            ]);
    }
    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return 'viettut_form_card';
    }
}