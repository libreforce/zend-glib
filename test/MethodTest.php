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

use \Zend\GLib\TypeGenerator;
use \Zend\GLib\ClassGenerator;
use \Zend\GLib\MethodGenerator;
use \Zend\GLib\ParameterGenerator;

use \Zend\GLib\NamingGenerator;
use \Zend\GLib\Naming\GnomeStrategy;


/**
 * @covers Zend\Idl\Document
 * @covers Zend\Idl\Node
 * @covers Zend\Idl\Exception\RuntimeException
 */
class MethodTest extends TestCase
{

    public function setUp()
    {
        //$lib = new LibraryGenerator();
        //$lib->setName('Dom');

        $class = new ClassGenerator(/*$lib*/);
        $class->setNamespaceName('DOM');// MySQL => my_sql_
        $class->setName('Node');

        $method = new MethodGenerator(/*parent, options*/);
        $method->setParentGenerator($class);
    }

    public function testMethod()
    {
        $class = new ClassGenerator();
        $class->setNamespaceName('DOM');// MySQL => my_sql_
        $class->setName('Node');

        //$method = $class->addMethod('appendChild');

        $type = new TypeGenerator('DomNode');// Node
        //$type->setParentGenerator($class);//  DOM
        $type->setPass('*');

        $parameter = new ParameterGenerator('childRef');
        $parameter->setType($type/*'DomNode*'*/);

        $method = new MethodGenerator(/*parent, options*/);
        $method->setParentGenerator($class);
        $method->setName('appendChild');// append_child
        $method->setType('DomNode*'/*$type*/);

        $method->setParameter($parameter);

        echo PHP_EOL . $method->generate('header') . PHP_EOL;
        $this->assertEquals('', '');
        //$this->assertEquals('', $method->generate());
    }

/*
    public function testNaming()
    {
        $class = new ClassGenerator();
        $class->setNamespaceName('MySQL');// MySQL => my_sql_
        $class->setName('Node');

        $naming = new NamingGenerator();
        $naming->setStrategy(new GnomeStrategy($class));
        $output = $naming->generateTypeName();
        echo PHP_EOL . $output . PHP_EOL;
        $output = $naming->generateMacroClass();
        echo $output . PHP_EOL;
        $output = $naming->generateFunctionName();
        echo $output . PHP_EOL;
        $output = $naming->generateProperty();
        echo $output . PHP_EOL;

        //echo PHP_EOL . $output . PHP_EOL;
        $this->assertEquals('', '');
    }
*/
}
