<?php

namespace Nca\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints as Assert;

use Silex\Application;

class ParticipationType extends AbstractType
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

            ->add('nom', 'text', array(
                'attr' => array(
                    'placeholder' => 'Ex : Dupont',
                ),
                'constraints' => array(
                    new Assert\NotBlank(array(
                        'message' => 'Le champ "nom" ne doit par être vide'
                    ))
                )
            ))
            ->add('prenom', 'text', array(
                'attr' => array(
                    'placeholder' => 'Ex : Jean',
                ),
            'constraints' => array(
                new Assert\NotBlank(array(
                    'message' => 'Le champ "prénom" ne doit par être vide'
                    ))
                )
            ))
            ->add('email', 'email', array(
                'attr' => array(
                    'placeholder' => 'Ex : jeandupont@xyzmail.fr',
                ),
                'constraints' => array(
                    new Assert\NotBlank(array(
                        'message' => 'le champ "email" ne doit par être vide'
                    )),
                    new Assert\Email(array(
                        'message' => 'L\'adresse email n\'est pas correcte'
                    ))
                )
            ))
            ->add('tel', 'text', array(
                'attr' => array(
                    'placeholder' => 'Ex : 0601020304',
                ),
                'constraints' => array(
                    new Assert\NotBlank(array(
                        'message' => 'Le champ "téléphone" ne doit par être vide'
                    )),
                    new Assert\Regex(array(
                        'pattern' => '/^((\+|00)33\s?|0)[1-9](\s?\d{2}){4}$/',
                        'message' => 'Le format du numéro de téléphone est incorrect'
                    ))
                )
            ))
            ->add('adresse', 'text', array(
                'constraints' => array(
                    new Assert\NotBlank(array(
                        'message' => 'Le champ "adresse" ne doit par être vide'
                    ))
                )
            ))
            ->add('cp', 'text', array(
                'constraints' => array(
                    new Assert\NotBlank(array(
                        'message' => 'Le champ "code postal" ne doit par être vide'
                    )),
                )
            ))
            ->add('ville', 'text', array(
                'constraints' => array(
                    new Assert\NotBlank(array(
                        'message' => 'Le champ "ville" ne doit par être vide'
                    )),
                )
            ))
            ->add('titre', 'text', array(
                'constraints' => array(
                    new Assert\NotBlank(array(
                        'message' => 'Le champ "titre" ne doit par être vide'
                    )),
                )
            ))
            ->add('lieu', 'text', array(
                'attr' => array(
                    'placeholder' => 'Ex: Promenade du Paillon',
                ),
                'data' => 'Promenade du Paillon',
                'constraints' => array(
                    new Assert\NotBlank(array(
                        'message' => 'Le champ "lieu" ne doit par être vide'
                    )),
                )
            ))
            ->add('date_photo', 'date', array(
                'widget' => 'choice',
                'format' => 'ddMMyyyy',
                'data' => new \DateTime('now'),
                'constraints' => array(
                    new Assert\NotBlank(array(
                        'message' => 'Le champ "date" ne doit par être vide'
                    )),

                )
            ))
            ->add('reglement', 'choice', array(
                'choices'   => array(
                    '1' => '',
                ),
                'multiple'  => true,
                'expanded'  => true,
                'constraints' => array(
                    new Assert\NotBlank(array(
                        'message' => 'Vous devez accepter le règlement du concours'
                    ))
                )
            ))
            ->add('image', 'text', array(
                'attr' => array(
                    'class' => 'test',
                ),
                'constraints' => array(
                    new Assert\NotBlank(array(
                        'message' => 'Vous devez charger une photo'
                    ))
                )
            ));

            $builder->addEventSubscriber($this->app['participation_post_submit_event_subscriber']);

    }

    public function getName()
    {
        return 'participation';
    }
}