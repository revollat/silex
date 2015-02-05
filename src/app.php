<?php
use Silex\Provider\FormServiceProvider;
use Silex\Provider\ValidatorServiceProvider;
use Silex\Provider\TranslationServiceProvider;

/*use Nca\Form\Type\ParticipationType;
use Nca\Form\Type\VoteType;
use Nca\Form\EventListener\ParticipationFormSubscriber;
use Nca\Form\EventListener\VoteFormSubscriber;
use Nca\Outils;*/

$app = new Silex\Application();

if(getenv('APP_ENV')){
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    $app['debug'] = true;
}

// generation d'URL'
$app->register(new Silex\Provider\UrlGeneratorServiceProvider());

// service templating
$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/../views',
));

// service pour créer les formulaires
$app->register(new FormServiceProvider());

/*$app['form.types'] = $app->share($app->extend('form.types', function ($types) use ($app) {
    $types['participation'] = new ParticipationType($app);
    $types['vote'] = new VoteType($app);
    return $types;
}));*/

/*$app['participation_post_submit_event_subscriber'] = function () use ($app) {
    return new ParticipationFormSubscriber($app);
};

$app['vote_post_submit_event_subscriber'] = function () use ($app) {
    return new VoteFormSubscriber($app);
};*/

// service de validation de formulaire
$app->register(new ValidatorServiceProvider());
$app->register(new TranslationServiceProvider(array(
    'translator.domains' => array(),
)));

// service d'envoi de mail
$port = getenv('APP_ENV') ? '1025' : '25';
$app->register(new Silex\Provider\SwiftmailerServiceProvider());
$app['swiftmailer.options'] = array(
    'host' => 'localhost',
    'port' => $port
);

/*if(getenv('APP_ENV')){
    $db_pass = '';
}else{
    $db_pass = '';
}
$app->register(new Silex\Provider\DoctrineServiceProvider(), array(
    'db.options' => array(
        'driver' => 'pdo_mysql',
        'dbhost' => 'localhost',
        'dbname' => 'paillon',
        'user' => 'paillon',
        'password' => $db_pass,
        'charset' => 'utf8'
    ),
));*/
