<?php
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

$app->get('/', function() use ($app) {
    return $app['twig']->render('accueil.twig');
})->bind('vote');