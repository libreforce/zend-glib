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

use \Zend\GLib\TypeGenerator;

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
     * @var string
     */
    protected $name;
    /**
     * @var TypeGenerator
     */
    protected $type;
    /**
     * @var boolean
     */
    protected $isVariadic=False;

    /**
     *
     */
    public function __construct($options)
    {
        if (is_string($options)) {
            $this->setName($options);
        }
        if (is_array($options)) {
            $this->setOptions($options);
        }
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
        if ($type instanceof TypeGenerator) {
            $this->type = $type;
        } else if (is_string($type)) {
            $this->type = new TypeGenerator($type);
        }
        return $this;
    }

    public function getType()
    {
        return $this->type;
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

    /**
     * @return string
     */
    public function generate($scope)
    {
        $output = '';// const unsigned char *argv[]
        $naming = new Naming\GnomeStrategy();
        $function_name = $naming->generateFunctionName($this);

        if ($this->isVariadic()) {
            return '...';
        }

        $output .= $this->getType()->generate($scope);

        $output .= ' ' . $function_name;

        if ($this->getType()->isArray()) {
            $output .= '[';
            $expression = $this->getType()->getExpressionArray();
            if ($expression!=NULL) {
                $output .= $expression;
            }
            $output .= ']';
        }

        return $output;
    }

}