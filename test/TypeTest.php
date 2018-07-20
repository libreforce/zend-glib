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


/**
 * @covers Zend\Idl\Document
 * @covers Zend\Idl\Node
 * @covers Zend\Idl\Exception\RuntimeException
 */
class TypeTest extends TestCase
{

    public function setUp()
    {
    }

    public function testType()
    {
        $parameter = new TypeGenerator('char');
        $parameter->setModifier('unsigned');
        $parameter->setQualifier('const');
        $parameter->setPass('*');

        $parameter->setArray();
        $parameter->setExpressionArray('1');

        $this->assertEquals('const unsigned char*', $parameter->generate());
    }

}
