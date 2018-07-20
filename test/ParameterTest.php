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

use \Zend\GLib\ParameterGenerator;
use \Zend\GLib\TypeGenerator;


/**
 * @covers Zend\Idl\Document
 * @covers Zend\Idl\Node
 * @covers Zend\Idl\Exception\RuntimeException
 */
class ParameterTest extends TestCase
{

    public function setUp()
    {
    }

    public function testParameter()
    {
        $parameter = new ParameterGenerator('argv');
        $type = new TypeGenerator('char');
        $type->setModifier('unsigned');
        $type->setQualifier('const');
        $type->setPass('*');
        $type->setArray();
        $parameter->setType($type);

        $this->assertEquals('const unsigned char* argv[]', $parameter->generate(null));
    }

    public function testParameterFromArray()
    {
        $type = new TypeGenerator('char');
        $type->setModifier('unsigned');
        $type->setQualifier('const');
        $type->setPass('*');
        $type->setArray();

        $options = array('name'=>'argv', 'type'=>$type);
        $parameter = new ParameterGenerator($options);

        $this->assertEquals('const unsigned char* argv[]', $parameter->generate(null));
    }

}
