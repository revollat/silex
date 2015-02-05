<?php
namespace Nca\Photos;

use Symfony\Component\Form\FormError;

use Imagine\Gd\Imagine;
use Imagine\Image\Box;
use Imagine\Image\Point;
use Imagine\Exception\Exception as ImageException;

class Miniatures
{

    static public function create($filename, $form, $upload_path)
    {
        try {

            /***** Traitement des miniatures d'image *****/
            $imagine = new Imagine();

            // Récup dimensions de l'image uploadée
            $image      = $imagine->open($upload_path . $filename); // provoque une erreur formulaire si le fichier n'existe pas
            $size       = $image->getSize();
            $hauteur    = $size->getHeight();
            $largeur    = $size->getWidth();

            // Config ds différentes dimensions
            $dimensions = new Box(250, 250);
            $dimensionsPaysage  = new Box(470, 246);
            $dimensionsPortrait  = new Box(246, 470);
            $dimensionsShare = $largeur > $hauteur ? $dimensionsPaysage : $dimensionsPortrait;

            // Creaction miniature
            $image
                ->thumbnail($dimensions, "outbound")
                ->save($upload_path . 'thumb/' . $filename)
            ;

            // Creation image réseaux sociaux
            $image
                ->thumbnail($dimensionsShare, "inset")
                ->save($upload_path . 'share/' . $filename)
            ;
            /***** FIN - Traitement des miniatures d'image *****/

        } catch (ImageException $e) { // si y'a des erreurs dans le traitement ci-dessus, j'ajoute une erreur au formulaire

//            if(getenv('APP_ENV')){ // Veritable message d'erreur (en anglais) dans l'environement de DEV
//                $form->addError(new FormError($e->getMessage()));
//            }else{
//                $form->addError(new FormError("Choisir une photo")); // Message générique en PROD
//            }

        }
    }


}