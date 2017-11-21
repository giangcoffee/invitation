<?php
/**
 * Created by PhpStorm.
 * User: giang
 * Date: 10/21/15
 * Time: 10:03 PM
 */

namespace Viettut\Form\Type;


use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Viettut\Entity\Core\Card;
use Viettut\Entity\Core\LibraryCard;
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
            ->add('forGroom')
            ->add('libraryCard', 'entity', array(
                'class' => LibraryCard::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('libCard')->select('libCard');
                }
            ))
            ->add('weddingDate', DateTimeType::class, [
                'widget' => 'single_text'
            ])
            ->add('partyDate', DateTimeType::class, [
                'widget' => 'single_text'
            ])
        ;

        $builder->addEventListener(
            FormEvents::PRE_SUBMIT,
            function (FormEvent $event) {
                $form = $event->getForm();
                $card = $event->getData();

                //create new Library
                if (array_key_exists('libraryCard', $card) && is_array($card['libraryCard'])) {
                    $form->remove('libraryCard');
                    $form->add('libraryCard', new LibraryCardFormType());
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