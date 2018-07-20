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

use \Zend\GLib\DocBlock\Tag\ParameterTag;
use \Zend\GLib\DocBlock\Tag\ImageTag;
use \Zend\GLib\DocBlock\Tag\ShortDescriptionTag;
use \Zend\GLib\TypeGenerator;
use \Zend\GLib\ClassGenerator;
use \Zend\GLib\ParameterGenerator;
use \Zend\GLib\MethodGenerator;


/**
 */
class ClassTest extends TestCase
{

    public function setUp()
    {
    }

    public function testClass()
    {
        $class_node = new ClassGenerator();
        $class_node->setNamespaceName('DOM');// MySQL => my_sql_
        $class_node->setName('Node');
        // getObjectName(); DOMNode

        /* Node insertBefore(in Node newChild,
         *                   in Node refChild)
         *                   raises(DOMException);
         */
        $method_insert_before = new MethodGenerator();
        //$method_insert_before->addParameter();
        $method_insert_before->setParentGenerator($class_node);
        //$method->setObjectName('DOMNode');
        $method_insert_before->setName('insertBefore');// append_child
        $method_insert_before->setType('DomNode*');

        $type_node = new TypeGenerator('DomNode');
        $type_node->setPass('*');
        $parameter_new_child = new ParameterGenerator('newChild');
        $parameter_new_child->setType($type_node);
        $method_insert_before->setParameter($parameter_new_child);

        /*
        $method_insert_before->addParameter('newChild')// array('name'=>'newChild', 'type'=>'DOMNode')
                             ->setType('DomNode')// array('name'=>'child', 'type'=>'DOMNode')
                             ->getType()->setPass('*');
        $method_insert_before->addParameter('refChild')// array('name'=>'newChild', 'type'=>'DOMNode')
                             ->setType('DomNode')// array('name'=>'child', 'type'=>'DOMNode')
                             ->getType()->setPass('*');
        */

        $class_node->addMethodFromGenerator($method_insert_before);// MySQL => my_sql_

        echo PHP_EOL;
        //echo $class_node->generate(/*source-boilplate*/);
        echo $class_node->generate("source");

        $this->assertTrue(true);

    }

}
