<?php

define('APPLICATION_PATH', realpath(dirname(__FILE__).'/../..'));

require APPLICATION_PATH . "/vendor/autoload.php";

$config = array(
    'view_manager' => array(
        // The TemplateMapResolver allows you to directly map template names
        // to specific templates. The following map would provide locations
        // for a home page template ("application/index/index"), as well as for
        // the layout ("layout/layout"), error pages ("error/index"), and
        // 404 page ("error/404"), resolving them to view scripts.
        'template_map' => array(
            'application/index/index' => __DIR__ .  '/../view/application/index/index.phtml',
            'site/layout'             => __DIR__ . '/../view/layout/layout.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
        ),

        // The TemplatePathStack takes an array of directories. Directories
        // are then searched in LIFO order (it's a stack) for the requested
        // view script. This is a nice solution for rapid application
        // development, but potentially introduces performance expense in
        // production due to the number of static calls necessary.
        //
        // The following adds an entry pointing to the view directory
        // of the current module. Make sure your keys differ between modules
        // to ensure that they are not overwritten -- or simply omit the key!
        'template_path_stack' => array(
            'application' => __DIR__ . '/../view',
        ),

        // This will be used as the default suffix for template scripts resolving, it defaults to 'phtml'.
        'default_template_suffix' => 'php',

        // Set the template name for the site's layout.
        //
        // By default, the MVC's default Rendering Strategy uses the
        // template name "layout/layout" for the site's layout.
        // Here, we tell it to use the "site/layout" template,
        // which we mapped via the TemplateMapResolver above.
        'layout' => 'site/layout',

        // By default, the MVC registers an "exception strategy", which is
        // triggered when a requested action raises an exception; it creates
        // a custom view model that wraps the exception, and selects a
        // template. We'll set it to "error/index".
        //
        // Additionally, we'll tell it that we want to display an exception
        // stack trace; you'll likely want to disable this by default.
        'display_exceptions' => true,
        'exception_template' => 'error/index',

       // Another strategy the MVC registers by default is a "route not
       // found" strategy. Basically, this gets triggered if (a) no route
       // matches the current request, (b) the controller specified in the
       // route match cannot be found in the service locator, (c) the controller
       // specified in the route match does not implement the DispatchableInterface
       // interface, or (d) if a response from a controller sets the
       // response status to 404.
       //
       // The default template used in such situations is "error", just
       // like the exception strategy. Here, we tell it to use the "error/404"
       // template (which we mapped via the TemplateMapResolver, above).
       //
       // You can opt in to inject the reason for a 404 situation; see the
       // various `Application\:\:ERROR_*`_ constants for a list of values.
       // Additionally, a number of 404 situations derive from exceptions
       // raised during routing or dispatching. You can opt-in to display
       // these.
       'display_not_found_reason' => true,
       'not_found_template'       => 'error/404',
    ),
);

/*
$paramTag = new Zend\GLib\DocBlock\Tag\ParameterTag('self');
$paramTag->setDescription('a #GObject');
$returnTag = new Zend\GLib\DocBlock\Tag\ReturnTag('a #gboolean');

$resolver = new Zend\View\Resolver\TemplatePathStack();
$resolver->addPath(realpath(APPLICATION_PATH . '/test/generator/template'));
$resolver->setDefaultSuffix('tpl');

$renderer = new Zend\View\Renderer\PhpRenderer();
$renderer->setResolver($resolver);

$viewModel = new Zend\View\Model\ViewModel(array('tag' => $returnTag));
$viewModel->setTemplate('tag');

echo $renderer->render($viewModel) . PHP_EOL;

$viewModel->setVariable('tag', $paramTag);
echo $renderer->render($viewModel) . PHP_EOL;
*/



$resolver = new Zend\View\Resolver\TemplatePathStack();
$resolver->addPath(realpath(APPLICATION_PATH . '/test/generator/template'));
$resolver->setDefaultSuffix('tpl');

$renderer = new Zend\View\Renderer\PhpRenderer();
$renderer->setResolver($resolver);

$layout = new Zend\View\Model\ViewModel();
$layout->setTemplate('header');
//$layout->setVariable('author', 'NoName');
$layout->setVariables(array(
    'date' => '1995-2003',
    'author' => 'NoName',
));


$content = new Zend\View\Model\ViewModel();
$content->setTemplate('method');
$content->setCaptureTo('content');
$layout->addChild($content);

//$helpers = new Zend\View\HelperPluginManager();
//$helpers->set($ServiceManager);

//$request = new Zend\Http\Request();
//$response = new Zend\Http\Response();
$view = new Zend\View\View();
//$view->setRequest(new stdClass);
$view->setResponse(new stdClass);

$view->addRenderingStrategy(function ($e) use ($renderer) {
    return $renderer;
});
$result = new stdClass;
$view->addResponseStrategy(function ($e) use ($result) {
    $result->content = $e->getResult();
});
$view->render($layout);
var_dump($view);
//echo $renderer->render($layout) . PHP_EOL;
