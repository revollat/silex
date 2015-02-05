<?php

namespace Nca\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Silex\Application;

class VoteType extends AbstractType
{
    /**
     * @var \Silex\Application
     */
    protected $app;

    public function __construct(Application $app){
        $this->app = $app;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('titre', 'text', array(
                'attr'   => array (
                    'placeholder' => 'Sélectionnez une photo ci-dessus',
                    'readonly' => 'readonly'                ),
                'label' => 'Titre de la photographie sélectionnée ci-dessus :',
                'constraints' => array(
                    new Assert\NotBlank(array(
                        'message' => 'Vous devez choisir une photo.'
                    ))
                )
            ))
            ->add('email', 'email', array(
                'attr' => array(
                    'placeholder' => 'Ex : jeandupont@xyzmail.fr',
                ),
                'label' => 'Votre email pour validation du vote :',
                'constraints' => array(
                    new Assert\NotBlank(array(
                        'message' => 'le champ "email" ne doit par être vide.'
                    )),
                    new Assert\Email(array(
                        'message' => 'L\'adresse email n\'est pas correcte.'
                    ))
                )
            ));

            $builder->addEventSubscriber($this->app['vote_post_submit_event_subscriber']);

    }

    public function getName()
    {
        return 'vote';
    }
}