<?php
/**
 * Created by PhpStorm.
 * User: giang
 * Date: 10/21/15
 * Time: 10:03 PM
 */

namespace Viettut\Form\Type;


use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Viettut\Entity\Core\Faq;
use Viettut\Entity\Core\Post;
use Viettut\Model\Core\PostInterface;
use Viettut\Utilities\StringFactory;

class PostFormType extends AbstractRoleSpecificFormType
{
    use StringFactory;
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('content')
            ->add('video')
            ->add('hash')
            ->add('hasVideo')
            ->add('published')
            ->add('thumbnail')
        ;

        $builder->addEventListener(
            FormEvents::POST_SUBMIT, function(FormEvent $event) {
                /**
                 * @var PostInterface $post
                 */
                $post = $event->getData();
                try {
                    $content = $post->getContent();
                    if (strlen($content) > 6) {
                        $summary = $this->getFirstParagraph($post->getContent());
                        $post->setSummary($summary);
                    }
                } catch (\Exception $ex) {

                }
            }
        );
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver
            ->setDefaults([
                'data_class' => Post::class,
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
        return 'viettut_form_post';
    }
}