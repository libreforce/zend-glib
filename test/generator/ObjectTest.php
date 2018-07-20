<?php

define('APPLICATION_PATH', realpath(dirname(__FILE__).'/../..'));

require APPLICATION_PATH . "/vendor/autoload.php";

use Zend\View\Model\ViewModel;
use Zend\View\Renderer\PhpRenderer;
use Zend\View\Resolver\TemplatePathStack;
use Zend\View\View;
use Zend\View\ViewEvent;

// configuration
$resolver = new TemplatePathStack();
$resolver->addPath(realpath(APPLICATION_PATH . '/test/generator/template'));
$resolver->setDefaultSuffix('tpl');

$phpRenderer = new PhpRenderer();
$phpRenderer->setResolver($resolver);


$helperPluginManager = $phpRenderer->getHelperPluginManager();
// Register an alias:
$helperPluginManager->setAlias('specialPurpose', ZendTest\GLib\View\Helper\SpecialPurpose::class);

// Register a factory:
$helperPluginManager->setFactory(ZendTest\GLib\View\Helper\SpecialPurpose::class, function () {
   $lowercaseHelper = new ZendTest\GLib\View\Helper\SpecialPurpose();

   // ...do some configuration or dependency injection...

   return $lowercaseHelper;
});


/*
$loader = new Zend\Loader\PluginClassLoader();
Zend\Loader\PluginClassLoader::addStaticMap(array(
    'specialPurpose' => 'ZendTest\GLib\View\Helper\SpecialPurpose',
));
$loader->registerPlugin('specialPurpose', 'ZendTest\GLib\View\Helper\SpecialPurpose');
*/

/// $phpRenderer->getHelperPluginManager()
/// $phpRenderer->setHelperPluginManager($helpers);

/*
$broker = $phpRenderer->getBroker();
$loader = $broker->getClassLoader();

// Register singly:
$loader->registerPlugin('specialPurpose', 'ZendTest\View\Helper\SpecialPurpose');

// Register several:
$loader->registerPlugins(array(
    'lowercase' => 'My\Helper\LowerCase',
    'uppercase' => 'My\Helper\UpperCase',
));
*/


$view = new View();
$view->getEventManager()
    ->attach(ViewEvent::EVENT_RENDERER, function () use ($phpRenderer) {
        return $phpRenderer;
    });

// example usage
$viewModel = new ViewModel(array('name' => 'appendChild'));
$viewModel->setTemplate('method');
$viewModel->setCaptureTo('content');

$layout = new ViewModel();
$layout->setVariables(array(
    'date' => '1995-2003',
    'author' => 'NoName',
));
$layout->setTemplate('header');
$layout->addChild($viewModel);
$layout->setOption('has_parent', true);

echo $view->render($layout);
