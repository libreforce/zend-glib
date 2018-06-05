<?php
/**
 * Component candidate to Zend Framework (http://framework.zend.com/)
 *
 * @link      https://github.com/libreforce/zend-idl for the canonical source repository
 * @copyright Copyright (c) 2018 lib-reforce.
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace ZendTest\GLib;

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Error\Notice;
use PHPUnit\Framework\Error\Warning;
use PHPUnit\Framework\Error\Error;

use \Zend\GLib\DocBlock\SectionDocBlock;
use \Zend\GLib\DocBlock\FunctionDocBlock;
use \Zend\GLib\DocBlock\PropertyDocBlock;
use \Zend\GLib\DocBlock\SignalDocBlock;
use \Zend\GLib\DocBlock\StructDocBlock;
use \Zend\GLib\DocBlock\EnumDocBlock;
use \Zend\GLib\DocBlock\ProgramDocBlock;


/**
 * @covers Zend\Idl\Document
 * @covers Zend\Idl\Node
 * @covers Zend\Idl\Exception\RuntimeException
 */
class DocBlockTest extends TestCase
{

    public function setUp()
    {
    }

    public function testSectionDocBlock()
    {
        $docBlock = new SectionDocBlock();
        $docBlock->setName('meepapp');
        $docBlock->setDescription('The application class handles ...');

        $docBlock->setImageTag('application.png');
        $docBlock->setShortDescriptionTag('the application class');
        $docBlock->setTitleTag('Meep application');
        $docBlock->setSectionIdTag('');
        $docBlock->setSeeAlsoTag('#MeepSettings');
        $docBlock->setStabilityTag('Stable');
        $docBlock->setIncludeTag('meep/app.h');

        $expect  = '';
        $expect .= "/**" . PHP_EOL;
        $expect .= " * SECTION: meepapp" . PHP_EOL;
        $expect .= " * @short_description: the application class" . PHP_EOL;
        $expect .= " * @title: Meep application" . PHP_EOL;
        $expect .= " * @section_id: " . PHP_EOL;
        $expect .= " * @see_also: #MeepSettings" . PHP_EOL;
        $expect .= " * @stability: Stable" . PHP_EOL;
        $expect .= " * @include: meep/app.h" . PHP_EOL;
        $expect .= " * @image: application.png" . PHP_EOL;
        $expect .= " * " . PHP_EOL;
        $expect .= " * The application class handles ..." . PHP_EOL;
        $expect .= " */" . PHP_EOL;

        $output = $docBlock->generate();
        $this->assertEquals($expect, $output);
    }

    public function testFunctionDocBlock()
    {
        $docBlock = new FunctionDocBlock();
        $docBlock->setName('function_name');
        //$docBlock->setShortDescription('The application class handles ...');
        $docBlock->setDescription(
'The function description goes here. You can use @par1 to refer to parameters
so that they are highlighted in the output. You can also use %constant
for constants, function_name2() for functions and #GtkWidget for links to
other declarations (which may be documented elsewhere).');
        $docBlock->addParameterTag('par1')->setDescription('description of parameter 1. These can extend over more than one line.');
        $docBlock->addParameterTag('par2')->setDescription('description of parameter 2');
        $docBlock->addParameterTag('...')->setDescription('a %NULL-terminated list of bars');
        $docBlock->setReturnTag('an integer.');
        $docBlock->setSinceTag('2.2');
        $docBlock->setDeprecateTag('2.18: Use other_function() instead.');

        $expect = '';
        $expect .= "/**" . PHP_EOL;
        $expect .= " * function_name:" . PHP_EOL;
        $expect .= " * @par1: description of parameter 1. These can extend over more than one line." . PHP_EOL;
        $expect .= " * @par2: description of parameter 2" . PHP_EOL;
        $expect .= " * @...: a %NULL-terminated list of bars" . PHP_EOL;
        $expect .= " * " . PHP_EOL;
        $expect .= " * The function description goes here. You can use @par1 to refer to parameters" . PHP_EOL;
        $expect .= " * so that they are highlighted in the output. You can also use %constant for" . PHP_EOL;
        $expect .= " * constants, function_name2() for functions and #GtkWidget for links to other" . PHP_EOL;
        $expect .= " * declarations (which may be documented elsewhere)." . PHP_EOL;
        $expect .= " * " . PHP_EOL;
        $expect .= " * Returns: an integer." . PHP_EOL;
        $expect .= " * " . PHP_EOL;
        $expect .= " * Since: 2.2" . PHP_EOL;
        $expect .= " * Deprecated: 2.18: Use other_function() instead." . PHP_EOL;
        $expect .= " */" . PHP_EOL;
        $output = $docBlock->generate();

        $this->assertEquals($expect, $output);
    }

    public function testPropertyDocBlock()
    {
        $docBlock = new PropertyDocBlock();
        $docBlock->setName('property_name');
        $docBlock->setObjectName('WidgetName');
        $docBlock->setDescription('The function description goes here.');

        $expect = '';
        $expect .= "/**" . PHP_EOL;
        $expect .= " * WidgetName:property_name:" . PHP_EOL;
        $expect .= " * " . PHP_EOL;
        $expect .= " * The function description goes here." . PHP_EOL;
        $expect .= " */" . PHP_EOL;
        $output = $docBlock->generate();

        $this->assertEquals($expect, $output);
    }

    public function testSignalDocBlock()
    {
        $docBlock = new SignalDocBlock();
        $docBlock->setName('foobarized');
        $docBlock->setObjectName('FooWidget');
        $docBlock->setDescription('The ::foobarized signal is emitted each time someone tries to foobarize @widget.');
        $docBlock->addParameterTag('widget')->setDescription('the widget that received the signal');
        $docBlock->addParameterTag('foo')->setDescription('some foo');
        $docBlock->addParameterTag('bar')->setDescription('some bar');

        $expect = '';
        $expect .= "/**" . PHP_EOL;
        $expect .= " * FooWidget:foobarized:" . PHP_EOL;
        $expect .= " * @widget: the widget that received the signal" . PHP_EOL;
        $expect .= " * @foo: some foo" . PHP_EOL;
        $expect .= " * @bar: some bar" . PHP_EOL;
        $expect .= " * " . PHP_EOL;
        $expect .= " * The ::foobarized signal is emitted each time someone tries to foobarize" . PHP_EOL;
        $expect .= " * @widget." . PHP_EOL;
        $expect .= " */" . PHP_EOL;
        $output = $docBlock->generate();

        $this->assertEquals($expect, $output);
    }

    public function testStructDocBlock()
    {
        $docBlock = new StructDocBlock();
        $docBlock->setName('FooWidget');
        $docBlock->setDescription('This is the best widget, ever.');
        $docBlock->addParameterTag('bar')->setDescription('some #gboolean');

        $expect = '';
        $expect .= "/**" . PHP_EOL;
        $expect .= " * FooWidget:" . PHP_EOL;
        $expect .= " * @bar: some #gboolean" . PHP_EOL;
        $expect .= " * " . PHP_EOL;
        $expect .= " * This is the best widget, ever." . PHP_EOL;
        $expect .= " */" . PHP_EOL;
        $output = $docBlock->generate();

        $this->assertEquals($expect, $output);
    }

    public function testEnumDocBlock()
    {
        $docBlock = new EnumDocBlock();
        $docBlock->setName('Something');
        $docBlock->setDescription('Enum values used for the thing, to specify the thing.');
        $docBlock->addParameterTag('SOMETHING_FOO')->setDescription('something foo');
        $docBlock->addParameterTag('SOMETHING_BAR')->setDescription('something bar');

        $expect = '';
        $expect .= "/**" . PHP_EOL;
        $expect .= " * Something:" . PHP_EOL;
        $expect .= " * @SOMETHING_FOO: something foo" . PHP_EOL;
        $expect .= " * @SOMETHING_BAR: something bar" . PHP_EOL;
        $expect .= " * " . PHP_EOL;
        $expect .= " * Enum values used for the thing, to specify the thing." . PHP_EOL;
        $expect .= " */" . PHP_EOL;
        $output = $docBlock->generate();

        $this->assertEquals($expect, $output);
    }

    public function testProgramDocBlock()
    {
        $docBlock = new ProgramDocBlock();
        $docBlock->setName('test-program');
        $docBlock->setShortDescriptionTag('A test program');
        $docBlock->setDescription('Long description of program.');
        $docBlock->setSynopsisTag('test-program [*OPTIONS*...] --arg1 *arg* *FILE*');
        $docBlock->setSeeAlsoTag('test(1)');
        $docBlock->setReturnTag('Zero on success, non-zero on failure');
        $docBlock->addArgTag('--arg1 *arg*')->setDescription('set arg1 to *arg*');
        $docBlock->addArgTag('--arg2 *arg*')->setDescription('set arg2 to *arg*');
        $docBlock->addArgTag('-v, --version')->setDescription('Print the version number');
        $docBlock->addArgTag('-h, --help')->setDescription('Print the help message');

        $expect = '';
        $expect .= "/**" . PHP_EOL;
        $expect .= " * PROGRAM:test-program" . PHP_EOL;
        $expect .= " * @short_description: A test program" . PHP_EOL;
        $expect .= " * @synopsis: test-program [*OPTIONS*...] --arg1 *arg* *FILE*" . PHP_EOL;
        $expect .= " * @see_also: test(1)" . PHP_EOL;
        $expect .= " * @--arg1 *arg*: set arg1 to *arg*" . PHP_EOL;
        $expect .= " * @--arg2 *arg*: set arg2 to *arg*" . PHP_EOL;
        $expect .= " * @-v, --version: Print the version number" . PHP_EOL;
        $expect .= " * @-h, --help: Print the help message" . PHP_EOL;
        $expect .= " * " . PHP_EOL;
        $expect .= " * Long description of program." . PHP_EOL;
        $expect .= " * " . PHP_EOL;
        $expect .= " * Returns: Zero on success, non-zero on failure" . PHP_EOL;
        $expect .= " */" . PHP_EOL;

        $output = $docBlock->generate();

        $this->assertEquals($expect, $output);
    }

    public function testDocBlockGenerator()
    {
        /*
        $docBlockGenerator = new DocBlockGenerator();
        $docBlockGenerator->setIndentation('    ');
        $docBlockGenerator->setName('MyWidget');
        $docBlockGenerator->setLicence('This program is free software');
        $docBlockGenerator->setWrapword(True);
        $docBlockGenerator->setScopes(array('source', 'header', 'types'));
        $docBlockGenerator->setScopes(array('source', 'header'));
        $docBlockGenerator->setScopes(array('source'));

        $programDocBlock = $docBlockGenerator->create('program');
        $programDocBlock->generate('header|source|types');

        $programDocBlock = $docBlockGenerator->create('file');
        $programDocBlock->generate('header|source|types');

        $programDocBlock = $docBlockGenerator->create('object');
        $programDocBlock->generate('header|source|types');

        $programDocBlock = $docBlockGenerator->create('struct');
        $programDocBlock->generate('header|source|types');

        $programDocBlock = $docBlockGenerator->create('function|method');
        $programDocBlock->generate('header|source|types');

        $programDocBlock = $docBlockGenerator->create('[child-]property');
        $programDocBlock->generate('header|source|types');

        $programDocBlock = $docBlockGenerator->create('signal');
        $programDocBlock->generate('header|source|types');

        $programDocBlock = $docBlockGenerator->create('style');
        $programDocBlock->generate('header|source|types');
        */

    }

}
