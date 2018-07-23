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
use \Zend\GLib\NamespaceGenerator;
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
class NamespaceTest extends TestCase
{
    public $namespace;

    public function setUp()
    {
        $this->namespace = NULL;
    }

    public function testNamespace()
    {
        $parentNamespace = new NamespaceGenerator();
        $parentNamespace->setName('Hello');

        $this->namespace = new NamespaceGenerator();
        $this->namespace->setName('World');
        $this->namespace->setParentGenerator($parentNamespace);

        $output = $this->namespace->generate('header');
        $this->assertTrue('Hello::World'==$output);

    }

}
