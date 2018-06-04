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


/**
 * @covers Zend\Idl\Document
 * @covers Zend\Idl\Node
 * @covers Zend\Idl\Exception\RuntimeException
 */
class TagTest extends TestCase
{

    public function setUp()
    {
    }

    public function testParameterTag()
    {
        $tag = new ParameterTag();
        $tag->setVariableName('foo');
        $tag->setDescription('some #boolean');

        $expect = '@foo: some #boolean';
        $output = $tag->generate();
        $this->assertEquals($expect, $output);

        $tag->setAnnotations('transfer none|nullable');
        $expect = '@foo: (transfer none) (nullable): some #boolean';
        $output = $tag->generate();
        $this->assertEquals($expect, $output);
    }

    public function testImageTag()
    {
        $tag = new ImageTag();
        $tag->setDescription('application.png');

        $expect = '@image: application.png';
        $output = $tag->generate();
        $this->assertEquals($expect, $output);

    }

}
