<?php
namespace Nca;

use Imagine\Gd\Imagine;

use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Constraints as Assert;

class Outils {

    // Renvoi les erreur d'un formulaire symfony sous forme d'un tableau $errors[]
    static public function getErrorsAsArray($form)
    {
        $errors = array();
        foreach ($form->getErrors() as $error)
            $errors[] = $error->getMessage();

        foreach ($form->all() as $key => $child) {
            if ($err = self::getErrorsAsArray($child))
                $errors[$key] = $err;
        }
        return $errors;
    }

    //Récupère les dernières images validées
    static public function getLastImages($app)
    {
        $arrCandidats = $app['db']->executeQuery("SELECT * FROM paillon WHERE moderation = 1 AND inscription = 1 ORDER BY id DESC LIMIT 12 ")->fetchAll();

        $lastimages = array();

        foreach($arrCandidats as $key => $candidat) {
            $lastimages[$key]['image']= $candidat['photo'];
            if(!empty($candidat['titre']))
                $lastimages[$key]['titre']= $candidat['titre'];
            else
                $lastimages[$key]['titre']= 'Sans titre';
        }

        return $lastimages;

    }

    // Validation de l'image pour le concours
    static public function isImageOk($file)
    {

        $return_value = true;

        // Validation poids et type image à l'aide du validateur Symfony  : http://symfony.com/doc/current/reference/constraints/Image.html
        $validator = Validation::createValidator();
        $violations = $validator->validateValue($file, array(new Assert\Image(array(
            'maxSize' => '10M',
            'mimeTypes' => array('image/jpeg', 'image/jpg')
        ))));
        if (count($violations) !== 0) {
            $return_value = false; // erreur validation Symfony2 (Assert\Image)
        }

        // Validation de la taille à l'aide de Imagine pour récupérer les tailles de l'image
        $imagine = new Imagine();
        $image      = $imagine->open($file);
        $size       = $image->getSize();
        $hauteur    = $size->getHeight();
        $largeur    = $size->getWidth();

        if( $largeur > $hauteur ){ // Paysage

            if( ($largeur < 3000) || ($hauteur < 2000) ) $return_value = false;

        }else{  // Portrait

            if( ($largeur < 2000) || ($hauteur < 3000) ) $return_value = false;

        }

        return $return_value;

    }

}