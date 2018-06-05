<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Zend\GLib;

//use Zend\Code\Generator\DocBlock\Tag;
//use Zend\Code\Generator\DocBlock\Tag\TagInterface;
//use Zend\Code\Generator\DocBlock\TagManager;
//use Zend\Code\Reflection\DocBlockReflection;
use \Zend\GLib\AbstractGenerator;

use function explode;
use function is_array;
use function sprintf;
use function str_replace;
use function strtolower;
use function trim;
use function wordwrap;

// my_object_class_init(const GObject &object)
class ParameterGenerator extends AbstractGenerator
{

    /**
     * @var bool
     */
     protected $name;
     protected $type;
     protected $qualifier;
     protected $modifier;
     protected $pass;
     protected $isArray=False;
     protected $expression;
     protected $isVariadic=False;

    /**
     *
     */
    public function __construct()
    {
    }

    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }

    public function getType()
    {
        return $this->type;
    }

    /**
     * signed
     * unsigned
     * short
     * long
     */
    public function setModifier($modifier)
    {
        $this->modifier = $modifier;
        return $this;
    }

    public function getModifier()
    {
        return $this->modifier;
    }

    /**
     * const
     */
    public function setQualifier($qualifier)
    {
        $this->qualifier = $qualifier;
        return $this;
    }

    public function getQualifier()
    {
        return $this->qualifier;
    }

    /**
     * *
     * &
     */
    public function setPass($pass)
    {
        $this->pass = $pass;
        return $this;
    }

    public function getPass()
    {
        return $this->pass;
    }

    public function setVariadic($isVariadic=true)
    {
        $this->isVariadic = $isVariadic;
        return $this;
    }

    public function isVariadic()
    {
        return $this->isVariadic;
    }

    public function setArray($isArray=True, $expression=null)
    {
        $this->isArray = $isArray;
        $this->expression = $expression;
        return $this;
    }

    public function getArray()
    {
        return $this->expression;
    }

    public function isArray()
    {
        return $this->isArray;
    }


    /**
     * @return string
     */
    public function generate()
    {
        $output = '';// const unsigned char *argv[]

        if ($this->isVariadic()) {
            return '...';
        }

        if ($this->qualifier!=null) {
            $output .= $this->getQualifier() . ' ';
        }

        if ($this->modifier!=null) {
            $output .= $this->getModifier() . ' ';
        }

        $output .= $this->getType();

        if ($this->pass!=null) {
            $output .= $this->getPass() . ' ';
        }

        $output .= $this->getName();

        if ($this->isArray()) {
            $output .= '[';
            if ($this->expression!=NULL) {
                $output .= $this->expression;
            }
            $output .= ']';
        }

        return $output;
    }

}