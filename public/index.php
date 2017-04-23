<?php
//Application router
require '../vendor/autoload.php';

$app = new \Slim\App();

$container = $app->getContainer();

$container['view'] = function ($container){
    $dir = dirname(__DIR__);

    $view = new \Slim\Views\Twig($dir . '/App/views', [
        'cache' => false
    ]);

    return $view;
};

//This parameter must be is instance of TWIG Environment! /!\ (no require)
$twigEnvironment = $container['view'];

$availableLang  = ['fr', 'en'];
$defaultLang = 'en';

/*
 * this middleware will add 'lang' container with lang slug (ex: fr) and create global variable 'lang' in twig
   environment
 */
$app->add(new slim3_multilanguage\MultilanguageMiddleware([
    'availableLang' => $availableLang,
    'defaultLang' => $defaultLang,
    'twig' => $twigEnvironment,
    'container' => $container
]));

$app->get('/no-page-multilanguage-support', 'CALLED FONCTION');

$app->group('/{lang:[a-z]{2}}', function () use ($container){

    //route for /{lang}
    $this->get('', 'CALLED FONCTION')->setName('home');

    //route for /{lang}/contact
    $this->get('/contact', 'CALLED FONCTION')->setName('contact');

});

$app->run();