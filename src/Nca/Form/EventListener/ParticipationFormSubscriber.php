<?php
namespace Nca\Form\EventListener;

use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormError;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

use Nca\Photos\Miniatures;

use Silex\Application;


class ParticipationFormSubscriber implements EventSubscriberInterface
{

    /**
     * @var \Silex\Application
     */
    protected $app;

    public function __construct(Application $app){
        $this->app = $app;
    }

    public static function getSubscribedEvents()
    {
        return array(FormEvents::POST_SUBMIT => 'postSubmit');
    }

    public function postSubmit(FormEvent $event)
    {
        $data = $event->getData();
        $form = $event->getForm();

        $statement = $this->app['db']->executeQuery('SELECT * FROM paillon WHERE email = ? AND inscription = 1', array($data['email']));
        $participation = $statement->fetch();
        if($participation){
            $form->addError(new FormError('Vous avez déjà participé. Le règlement n\'autorise qu\'une seule participation par personne. '));
        }

        // Traitement des miniatures
        if(!is_file($this->app['upload_dir'] . 'thumb/' . $data['image'])){
            Miniatures::create($data['image'], $form, $this->app['upload_dir']);
        }

    }
}